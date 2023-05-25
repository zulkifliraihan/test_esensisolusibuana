<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(n+2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.item input {
            padding-left: 5px;
        }

        .invoice-box table tr.item td:first-child input {
            margin-left: -5px;
            width: 100%;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box input[type=number] {
            width: 60px;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }

    </style>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.css">
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td style="width: 250px;">
                                <h1 style="margin:0;">Invoice</h1>
                            </td>
                            <td style="width: 250px;">
                            </td>

                            <td style="width: 220px;">
                                <table>
                                    <tr>
                                        <td style="border-right: 1px solid black">From</td>
                                        <td class="text-left pl-2">
                                            <b>Discovery Designs</b>
                                            <br>
                                            41 St Vincent Place Glasgow G1 2ER Scotland
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td style="width: 300px;">
                                <table style="">
                                    <tr>
                                        <td style="border-right: 1px solid black; width: 90px;">Invoice ID</td>
                                        <td class="text-left pl-4">{{ $invoice->id }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid black; width: 90px;">Issue Date</td>
                                        <td class="text-left pl-4">{{ Carbon\Carbon::parse($invoice->issued_date)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid black; width: 90px;">Due Date</td>
                                        <td class="text-left pl-4">{{ Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border-right: 1px solid black; width: 90px;">Subject</td>
                                        <td class="text-left pl-4">{{ $invoice->subject }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 100px;">
                            </td>

                            <td style="width: 185px;">
                                <table>
                                    <tr>
                                        <td style="border-right: 1px solid black; padding-right: 25px;">To</td>
                                        <td class="text-left pl-2">
                                            <b>{{ $invoice->customer->name }}</b>
                                            <br>
                                            {{ $invoice->customer->address }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>


            <tr>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Item Type</th>
                            <th>Description</th>

                            <th class="text-center">Qty</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->item as $value)
                            <tr>
                                <td class="left">
                                    {{ $value->item->type->name }}
                                </td>
                                <td class="text-left">
                                    {{ $value->item->name }}
                                </td>
                                <td class="text-center">
                                    {{ $value->qty }}
                                </td>
                                <td class="text-center">
                                    £{{ number_format($value->item->unit_price, 2) }}
                                </td>
                                <td class="text-center">
                                    £{{ number_format($value->total_price, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </tr>

            <tr>
                <div class="col-lg-5 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                            <tr>
                                <td class="left">
                                    <strong>Subtotal</strong>
                                </td>
                                <td class="right">
                                    £{{ number_format($invoice->sub_total, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="left">
                                    <strong>TAX ({{ $invoice->tax_rate }}%)</strong>
                                </td>
                                <td class="right">
                                    £{{ number_format($invoice->tax_total, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="left">
                                    <strong>Payments</strong>
                                </td>
                                <td class="right">
                                    <strong>
                                        £{{ number_format($invoice->grand_total, 2) }}
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </tr>

            <tr>
                <div class="col-lg-6 mt-4 col-sm-5 ml-auto">
                    <table class="table table-clear">
                        <tbody>
                            <tr>
                                <td class="left">
                                    <strong>Amount Due</strong>
                                </td>
                                <td class="right">0</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </tr>

        </table>
    </div>

    <script>
        window.onload = function() {
            window.print(); 
        };
    </script>
</body>

</html>
