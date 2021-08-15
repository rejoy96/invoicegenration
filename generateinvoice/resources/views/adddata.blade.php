<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <style>
        body {
            color: #404E67;
            background: #F5F7FA;
            font-family: 'Open Sans', sans-serif;
        }

        .table-wrapper {
            width: 700px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 10px;
            margin: 0 0 10px;
        }

        .table-title h2 {
            margin: 6px 0 0;
            font-size: 22px;
        }

        .table-title .add-new {
            float: right;
            height: 30px;
            font-weight: bold;
            font-size: 12px;
            text-shadow: none;
            min-width: 100px;
            border-radius: 50px;
            line-height: 13px;
        }

        .table-title .add-new i {
            margin-right: 4px;
        }

        table.table {
            table-layout: fixed;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table th:last-child {
            width: 100px;
        }

        table.table td a {
            cursor: pointer;
            display: inline-block;
            margin: 0 5px;
            min-width: 24px;
        }

        table.table td a.add {
            color: #27C46B;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #E34724;
        }

        table.table td i {
            font-size: 19px;
        }

        table.table td a.add i {
            font-size: 24px;
            margin-right: -1px;
            position: relative;
            top: 3px;
        }

        table.table .form-control {
            height: 32px;
            line-height: 32px;
            box-shadow: none;
            border-radius: 2px;
        }

        table.table .form-control.error {
            border-color: #f50000;
        }

        table.table td .add {
            display: none;
        }
    </style>
    <script>
        var linetotalsum = 0
        $(document).ready(function() {

        $("#generate").click(function () {
            // var divContents = $("#dvContainer").html();
            // var printWindow = window.open('', '', 'height=400,width=800');
            // printWindow.document.write('<html><head><title>DIV Contents</title>');
            // printWindow.document.write('</head><body >');
            // printWindow.document.write(divContents);
            // printWindow.document.write('</body></html>');
            // printWindow.document.close();
            // printWindow.print();
                window.print() 

        });
   
            $('#discountcheck').click(function() {
                discountval = $("#discountvalue").val()
                subtotal = $("#Subtotaltaxtd").text()

                if ($(this).prop("checked") == true) {
                    $('#checkspan').text("Discount$");
                    $("#total").html(subtotal - discountval)
                } else {
                    $('#checkspan').text("Discount%");
                    if (discountval > 0) {
                        $("#total").html(subtotal * discountval / 100)
                    } else {
                        $("#total").html(subtotal)
                    }
                }

            });

            $("#discountvalue").keyup(function() {
                if (!isNaN($(this).val())) {

                    discountval = $(this).val()

                    subtotal = $("#Subtotaltaxtd").text()

                    if ($('#discountcheck').prop("checked") == true) {
                        $("#total").html(subtotal - discountval)
                    } else {
                        if (discountval > 0) {
                            $("#total").html(subtotal * discountval / 100)
                        } else {
                            $("#total").html(subtotal)
                        }
                    }


                }
            });
            var subtotal = 0
            var linetotalsum = 0
            $('[data-toggle="tooltip"]').tooltip();
            var actions = $("table td:last-child").html();
            // Append table with add row form on add new button click
            $(".add-new").click(function() {


                $("#subtotal").remove();
                $("#subtotaltax").remove();
                $("#subtotaltax").remove();
                $("#discount").remove();
                $("#unit").remove();
                $(this).attr("disabled", "disabled");
                var index = $("table tbody tr:last-child").index();
                var row = '<tr>' +
                    '<td><input type="text" name="name1" id="name1" class="form-control" ></td>' +
                    '<td name = "Quantity1"><input type="text" name="Quantity" id="Quantity" class="form-control" ></td>' +
                    '<td name = "unitprice1"><input type="text" name="unitprice" id="unitprice" class="form-control" ></td>' +
                    '<td name= "tax1"><input type="text" class="form-control" name="tax" id="tax"></td>' +
                    '<td name = "linetotal1"><input type="text" class="form-control" name="linetotal" id="linetotal" disabled></td>' +
                    '<td>' + actions + '</td>' +
                    '</tr>';
                var subtotal = '<tr id = "subtotal">' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td>Subtotal</td>' +
                    '<td id ="Subtotaltd">' + '0' + '</td>' +
                    '</tr>';
                var subtotaltax = '<tr id = "subtotaltax">' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td>Subtotal(tax)</td>' +
                    '<td id ="Subtotaltaxtd">' + '0' + '</td>' +
                    '</tr>';
                var Discount = '<tr id = "discount">' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td> <div class="form-check"><input class="form-check-input mt-2" type="checkbox"  id="discountcheck"><span id="checkspan">Discount%</span></div></td>' +
                    '<td>' + '<input type="text" class="form-control" name="discountvalue" id="discountvalue" value="0">' + '</td>' +
                    '</tr>';
                var unit = '<tr id = "unit">' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td>Total</td>' +
                    '<td id ="total">' + '0' + '</td>' +
                    '</tr>';
                $("table").append(row);
                $("table").append(subtotal);
                $("table").append(subtotaltax);
                $("table").append(Discount);
                $("table").append(unit);
                $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
                $('[data-toggle="tooltip"]').tooltip();
                $('#discountcheck').click(function() {
                    discountval = $("#discountvalue").val()
                    subtotal = $("#Subtotaltaxtd").text()
                    if ($(this).prop("checked") == true) {
                        $('#checkspan').text("Discount$");
                        $("#total").html(subtotal - discountval)
                    } else {
                        $('#checkspan').text("Discount%");
                        if (discountval > 0) {
                            $("#total").html(subtotal * discountval / 100)
                        } else {
                            $("#total").html(subtotal)
                        }
                    }

                });
            });
            $("#discountvalue").keyup(function() {
                if (!isNaN($(this).val())) {

                    discountval = $(this).val()

                    subtotal = $("#Subtotaltaxtd").text()

                    if ($('#discountcheck').prop("checked") == true) {
                        $("#total").html(subtotal - discountval)
                    } else {
                        if (discountval > 0) {
                            $("#total").html(subtotal * discountval / 100)
                        } else {
                            $("#total").html(subtotal)
                        }
                    }


                }
            });
            // Add row on add button click
            $(document).on("click", ".add", function() {
                var empty = false;
                var input = $(this).parents("tr").find('input[type="text"]');
                var i = 0
                var quantity = 0
                var unitprice = 0
                var linetotal = 0


                input.each(function() {
                    if (!$(this).val() && i != 4) {
                        $(this).addClass("error");
                        empty = true;
                    } else if (isNaN($(this).val()) && i > 0 && i != 4) {
                        $(this).addClass("error");
                        empty = true;


                    } else {
                        $(this).removeClass("error");
                        if (empty == false && i == 1) {
                            quantity = $(this).val();

                        }
                        if (empty == false && i == 2) {
                            unitprice = $(this).val();

                        }

                        if (empty == false && i == 4) {
                            linetotal = unitprice * quantity;
                            linetotalsum = linetotal + linetotalsum
                            $(this).val(linetotal);

                        }
                        var linttotalwithpecentsum
                        if (empty == false && i == 3) {
                            percent = $(this).val();
                            linttotalwithpecent = (linetotal * percent) / 100
                        }
                    }


                    i++;
                });





                $(this).parents("tr").find(".error").first().focus();
                if (!empty) {
                    i = 0
                    input.each(function() {
                        $(this).parent("td").html($(this).val());

                    });
                    $(this).parents("tr").find(".add, .edit").toggle();
                    $(".add-new").removeAttr("disabled");
                }
                var unitprice = $(document).find('td[name="unitprice1"]');
                unitpricesum = 0
                unitprice.each(function() {
                    if (!isNaN($(this).text())) {
                        unitpricesum = unitpricesum + parseFloat($(this).text())

                    }

                });
                var subtotalobj = $(document).find('td[name="Quantity1"]');
                subtotalsum = 0
                subtotalobj.each(function() {

                    if (!isNaN($(this).text())) {
                        subtotalsum = subtotalsum + parseFloat($(this).text())
                    }

                });
                var linttotal1obj = $(document).find('td[name="linetotal1"]');
                lintotalwithoutpercent = 0
                linearray = []
                linttotal1obj.each(function() {

                    if (!isNaN($(this).text())) {
                        lintotalwithoutpercent = lintotalwithoutpercent + parseFloat($(this).text())
                        linearray.push(parseFloat($(this).text()))
                    }

                });
                var taxobj = $(document).find('td[name="tax1"]');
                var taxsumarry = []
                taxobj.each(function() {
                    var j = 0

                    if (!isNaN($(this).text())) {
                        if (typeof linearray[j] != undefined) {
                            val = parseFloat($(this).text())
                            if (val != 0) {
                                taxsumarry.push((val * linearray[j]) / 100)
                            } else {
                                taxsumarry.push(linearray[j])
                            }

                        }

                    }

                });
                // console.log(taxsumarry)

                var sum = taxsumarry.reduce(function(a, b) {
                    return a + b;
                }, 0);




                subtotalsum = subtotalsum + unitpricesum
                $("#Subtotaltd").html(lintotalwithoutpercent)
                $("#Subtotaltaxtd").html(lintotalwithoutpercent + sum)
                discountval = $("#discountvalue").val()

                if ($('#discountcheck').prop("checked") == true) {
                    $("#total").html((lintotalwithoutpercent + sum) - discountval)
                } else {
                    sumtotal = lintotalwithoutpercent + sum
                    if (discountval > 0) {
                        $("#total").html(sumtotal - (lintotalwithoutpercent + sum) * discountval / 100)
                    } else {
                        $("#total").html(lintotalwithoutpercent + sum)
                    }

                }



            });
            // Edit row on edit button click
            $(document).on("click", ".edit", function() {
                var i = 0;
                $(this).parents("tr").find("td:not(:last-child)").each(function() {


                    if (i == 1) {

                        $(this).html('<input type="text" class="form-control" id="Quantity" name ="Quantity" value="' + $(this).text() + '">');
                    } else if (i == 4) {
                        $(this).html('<input type="text" class="form-control" name="linetotal" id="linetotal"  value="' + $(this).text() + '"disabled> ');
                    } else if (i == 2) {
                        $(this).html('<input type="text" class="form-control" id="unitprice" name ="unitprice" value="' + $(this).text() + '">');

                    } else {
                        $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '"> ');
                    }

                    i++
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").attr("disabled", "disabled");
            });
            // Delete row on delete button click
            $(document).on("click", ".delete", function() {
                $(this).parents("tr").remove();
                $(".add-new").removeAttr("disabled");
            });
        });
    </script>
</head>

<body>
    <div class="container-lg">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-4">
                            <h2><b>Customer</b></h2>
                        </div>
                        
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add New</button>
                        </div>
                         <div class="col-sm-4">
                            <button type="button" class="btn btn-info " id="generate"><i class="fa fa-plus"></i>Genarate invoice</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>

                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Tax</th>
                            <th>line total</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>--</td>
                            <td name="Quantity1" id="Quantity1">0</td>
                            <td name="unitprice1" id="unitprice">0</td>
                            <td name="tax1">0</td>
                            <td name="linetotal1"><input type="text" class="form-control" value="0" disabled></td>
                            <td>
                                <a class="add" title="Add" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
                                <a class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                <a class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                            </td>
                        </tr>
                        <tr id="subtotal">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Subtotal</td>
                            <td id="Subtotaltd">0</td>
                        </tr>
                        <tr id="subtotaltax">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Subtotal(tax)</td>
                            <td id="Subtotaltaxtd">0</td>
                        </tr>
                        <tr id="discount">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="form-check "><input class="form-check-input mt-2" type="checkbox" id="discountcheck"><span id="checkspan">Discount%</span></div>
                            </td>
                            <td><input type="text" class="form-control" name="discountvalue" id="discountvalue" value="0" </td>
                        </tr>
                        <tr id="unit">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td id="total"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</body>

</html>