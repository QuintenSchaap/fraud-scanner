<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index', ['customers' => []]);
    }

    public function runScan(Request $request)
    {
        try {
            $response = Http::get('http://localhost:8001/api/v1/customers');

            if (!$response->successful()) {
                return back()->withErrors(['API returned error: ' . $response->status()]);
            }

            $data = $response->json();
            $customers = $data['customers'] ?? [];
            $ipCounts = [];
            $ibanCounts = [];

            foreach ($customers as $customerFraudCheck) {
                $ip = $customerFraudCheck['ipAddress'];
                $iban = $customerFraudCheck['iban'];

                $ipCounts[$ip] = ($ipCounts[$ip] ?? 0) + 1;
                $ibanCounts[$iban] = ($ibanCounts[$iban] ?? 0) + 1;
            }

            $scan = Scan::create([
                'scanned_at' => Carbon::now(),
            ]);

            $savedCustomers = [];

            foreach ($customers as $customer) {
                $isFraud = $this->checkForFraud($customer, $ipCounts, $ibanCounts);

                $savedCustomer = $scan->customers()->create([
                    'customer_id' => $customer['customerId'],
                    'bsn' => $customer['bsn'],
                    'first_name' => $customer['firstName'],
                    'last_name' => $customer['lastName'],
                    'date_of_birth' => Carbon::createFromFormat('d-m-Y', $customer['dateOfBirth']),
                    'phone_number' => $customer['phoneNumber'],
                    'email' => $customer['email'],
                    'tag' => $customer['tag'],
                    'address' => json_encode($customer['address']),
                    'products' => json_encode($customer['products']),
                    'ip_address' => $customer['ipAddress'],
                    'iban' => $customer['iban'],
                    'last_invoice_date' => Carbon::createFromFormat('d-m-Y', $customer['lastInvoiceDate']),
                    'last_login_date_time' => isset($customer['lastLoginDateTime']) ? Carbon::parse($customer['lastLoginDateTime']) : null,
                    'is_fraudulent' => $isFraud,
                ]);

                $savedCustomers[] = $savedCustomer;
            }

            return view('scan.index', ['customers' => $savedCustomers]);

        } catch (\Exception $e) {
            return back()->withErrors(['Could not connect to API: ' . $e->getMessage()]);
        }
    }

    private function checkForFraud($customer, $ipCounts, $ibanCounts)
    {
        $ip = $customer['ipAddress'];
        $iban = $customer['iban'];

        $ipDuplicate = isset($ipCounts[$ip]) && $ipCounts[$ip] > 1;
        $ibanDuplicate = isset($ibanCounts[$iban]) && $ibanCounts[$iban] > 1;

        return $ipDuplicate || $ibanDuplicate;
    }

    public function allScans()
    {
        $scans = Scan::with('customers')->orderBy('scanned_at', 'desc')->get();
        return view('scan.list', compact('scans'));
    }
}
