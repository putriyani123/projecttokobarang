<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionSingleExport implements FromView, ShouldAutoSize
{
    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function view(): View
    {
        return view('transactions.export_excel', [
            'transaction' => $this->transaction
        ]);
    }
}
