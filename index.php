<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drag-Drop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
    /* .selected { background-color: #d1e7fd !important; } */
        .ui-sortable-helper {
            background-color: #f0f0f0 !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        tr {
            cursor: move;
        }
    </style>
</head>
<body>
<?php require_once('config.php'); 
$sql = "SELECT * FROM sorting_record order by display_order";
$rows = $conn->query($sql);
?>
    <div class="container mt-5">
        <h3 class="text-center">Dynamics Drag and Drop table rows</h3>
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody class="row_position">
                <?php while($row = $rows->fetch_assoc()) {?>
                <tr id="<?php echo $row['id']?>">
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['description'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<script>
$(document).ready(function() {
    var table = $("#mytable").DataTable({
        ordering: false,
        searching: false,
        paging: false
    });

    // Row selection with Ctrl
    $('#mytable tbody').on('click', 'tr', function(e) {
        if (e.ctrlKey || e.metaKey) {
            $(this).toggleClass('selected');
        } else {
            $('#mytable tbody tr').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    // Multi-row drag and drop
    $(".row_position").sortable({
        delay: 150,
        helper: function(e, tr) {
            var $selected = tr.hasClass("selected") ? $(".selected") : tr;
            tr.data("multidrag", $selected);
            var $helper = tr.clone();
            $helper.children().each(function(index) {
                $(this).width(tr.children().eq(index).width());
            });
            return $helper;
        },
        start: function(e, ui) {
            var $selected = ui.item.hasClass("selected") ? $(".selected") : ui.item;
            $selected.not(ui.item).hide();
        },
        stop: function(e, ui) {
            var $selected = ui.item.data("multidrag");
            if ($selected.length > 1) {
                $selected.show();
                $selected.insertAfter(ui.item);
                ui.item.remove();
            } else {
                $selected.show();
            }
            var selectedData = [];
            $(".row_position>tr").each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    }).disableSelection();
});

function updateOrder(data){
    $.ajax({
        url: "update_order.php",
        type: "POST",
        data: {
            allData: data
        },
    });
}
</script>
</body>
</html>
                
</script>

<style>
    .drag-drop{
        cursor: move;;
        text-align: center;
        font-size: 1.2em;
        user-select: none;
        width: 30px;
    }
    .ui-sortable-helper {
        background-color: #f0f0f0 !important; 
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
</style>


</html>