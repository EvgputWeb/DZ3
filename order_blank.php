<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order blank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.min.css">
    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        body {
            padding: 30px;
        }
        .order-field {
            width: 650px;
            border: 2px solid black;
            border-bottom-width: 1px;
            border-top: none;
            padding: 15px;
            font-family: "Verdana", sans-serif;
            font-size: 15px;
        }
        .order-header {
            border: 2px solid black;
            background-color: #e6e6fa;
            font-size: 16px;
        }
        .order-items {
            border-bottom-width: 2px;
        }
        .order-field p {
            padding:0;
            margin:0;
        }
        .order-field p.field-title {
            font-weight: bold;
            text-decoration: underline;
            color: #333333;
            margin-bottom: 8px;
        }
        .order-field p.customer-name {
            font-size: 16px;
            color: #006400;
            margin-bottom: 5px;
        }
        .items-table {
            border: 1px solid #d3d3d3;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }
        .items-table thead {
            background-color: #eaeaea;
        }
        .items-table tbody {
            font-size: 14px;
        }
        .items-table td {
            padding: 7px 0;
            margin: 0;
            border: 1px solid #d3d3d3;
            vertical-align: middle;
        }
        .items-table .product-name-cell {
            text-align: left;
            padding-left: 10px;
        }
        .items-table .item-comment {
            font-size: 11px;
            font-style: italic;
            color: gray;
        }
        .items-table tfoot {
            background-color: #f3f3f3;
        }
        .items-table tfoot td {
            text-align: right;
            padding: 7px 15px 5px 0;
        }
        .items-table .total-sum-cell {
            text-align: center;
            padding: 7px 0 5px 0;
            font-weight: bold;
            color: darkgreen;
        }
    </style>

</head>
<body>

    <div class="order-field order-header">
        Order Number: <b><?php echo $xml->attributes()->PurchaseOrderNumber; ?></b>, &nbsp;
        Order Date:   <b><?php echo $xml->attributes()->OrderDate; ?></b>
    </div>

    <?php foreach ($xml->Address as $customerAddress): ?>
    <div class="order-field">
        <p class="field-title">
            <?php echo $customerAddress->attributes()->Type; ?>
            Address
        </p>
        <p class="customer-name">
            <?php echo $customerAddress->Name; ?>
        </p>
        <p class="customer-address">
            <?php
                echo $customerAddress->Street . ', ';
                echo $customerAddress->City . ', ';
                echo $customerAddress->State . ', ';
                echo $customerAddress->Zip . ', ';
                echo $customerAddress->Country;
            ?>
        </p>
    </div>
    <?php endforeach; ?>

    <?php if (isset($xml->DeliveryNotes) && !empty($xml->DeliveryNotes)): ?>
    <div class="order-field">
        <p class="field-title">
            Delivery Notes
        </p>
        <p>
            <?php echo $xml->DeliveryNotes; ?>
        </p>
    </div>
    <?php endif; ?>

    <div class="order-field order-items">
        <p class="field-title">
            Items
        </p>
        <table class="items-table">
            <thead>
                <tr>
                    <td width="12%">Part #</td>
                    <td width="34%">Product Name</td>
                    <td width="16%">Ship Date</td>
                    <td width="10%">Qty</td>
                    <td width="13%">Price</td>
                    <td width="15%">Sum</td>
                </tr>
            </thead>
            <tbody>
                <?php $totalSum = 0; ?>
                <?php foreach ($xml->Items->Item as $item): ?>
                <tr>
                    <td><?php echo $item->attributes()->PartNumber; ?></td>
                    <td class="product-name-cell">
                        <?php echo $item->ProductName; ?>
                        <?php if (isset($item->Comment) && !empty($item->Comment)):  ?>
                        <?php   echo '<br><span class="item-comment">' . $item->Comment . '</span>';  ?>
                        <?php endif;  ?>
                    </td>
                    <td><?php echo $item->ShipDate; ?></td>
                    <td><?php echo $item->Quantity; ?></td>
                    <td><?php echo $item->USPrice; ?></td>
                    <td><?php echo sprintf('%.2f',$item->Quantity*(float)$item->USPrice); ?></td>
                </tr>
                <?php    $totalSum += $item->Quantity*(float)$item->USPrice; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">Total sum = </td>
                    <td class="total-sum-cell"><?php echo sprintf('%.2f', $totalSum); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>