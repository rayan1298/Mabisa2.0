<?php
include 'script.php';

$data = [];
$maintenance_area_description_query = "
    SELECT
        maintenance_governance.*,
        maintenance_category.description category,
        maintenance_area.description area_description
    FROM
        `maintenance_governance`
    LEFT JOIN maintenance_category ON maintenance_governance.cat_code = maintenance_category.code
    LEFT JOIN maintenance_area ON maintenance_governance.area_keyctr = maintenance_area.keyctr;
    
    
    ;
";

$maintenance_area_description_result = mysqli_query($conn, $maintenance_area_description_query);



if ($maintenance_area_description_result && mysqli_num_rows($maintenance_area_description_result) > 0) {
    // Fetch and display each row with var_dump
    while ($maintenance_area_description_row = mysqli_fetch_assoc($maintenance_area_description_result)) {

        // maintenance_governance
        $maintenance_governance_query = "SELECT * FROM `maintenance_governance` where desc_keyctr = '$maintenance_area_description_row[keyctr]'";
        $maintenance_governance_result = mysqli_query($conn, $maintenance_governance_query);

        if ($maintenance_governance_result && mysqli_num_rows($maintenance_governance_result) > 0) {
            while ($maintenance_governance_row = mysqli_fetch_assoc($maintenance_governance_result)) {

                $query2_data = $maintenance_governance_row;

                // maintenance_area_indicators
                $maintenance_area_indicators_query = "SELECT * FROM `maintenance_area_indicators` where governance_code = '$maintenance_governance_row[keyctr]'";
                $maintenance_area_indicators_result = mysqli_query($conn, $maintenance_area_indicators_query);



                if ($maintenance_area_indicators_result && mysqli_num_rows($maintenance_area_indicators_result) > 0) {
                    while ($maintenance_area_indicators_row = mysqli_fetch_assoc($maintenance_area_indicators_result)) {

                        $query3_data = $maintenance_area_indicators_row;


                        // maintenance_criteria_setup
                        $maintenance_criteria_setup_query = "
                            SELECT 
                            
                                msc.keyctr AS keyctr,
                                mam.description,
                                mam.reqs_code,
                                msc.movdocs_reqs documentary_requirements,
                                mds.srcdesc data_source


                            FROM `maintenance_criteria_setup` msc 
                            left JOIN maintenance_criteria_version AS mcv
                            ON
                                msc.version_keyctr = mcv.keyctr
                            left JOIN maintenance_area_mininumreqs AS mam
                            ON
                                msc.minreqs_keyctr = mam.keyctr
                            LEFT JOIN maintenance_document_source AS mds
                            ON
                                msc.data_source = mds.keyctr 
                            
                            where msc.indicator_keyctr  = '$maintenance_area_indicators_row[keyctr]'
                            order by mam.reqs_code asc
                            ";
                        $maintenance_criteria_setup_result = mysqli_query($conn, $maintenance_criteria_setup_query);


                        if ($maintenance_criteria_setup_result && mysqli_num_rows($maintenance_criteria_setup_result) > 0) {
                            while ($maintenance_criteria_setup_row = mysqli_fetch_assoc($maintenance_criteria_setup_result)) {

                                $data[$maintenance_area_description_row['category']. " " . $maintenance_area_description_row['area_description']  . ": " . $maintenance_area_description_row['description']][] = array(
                                    'keyctr' => $maintenance_criteria_setup_row['keyctr'],
                                    'indicator_code' => $maintenance_area_indicators_row['indicator_code'],
                                    'indicator_description' => $maintenance_area_indicators_row['indicator_description'],
                                    'relevance_definition' => $maintenance_area_indicators_row['relevance_def'],
                                    'reqs_code' => $maintenance_criteria_setup_row['reqs_code'],
                                    'documentary_requirements' => $maintenance_criteria_setup_row['documentary_requirements'],
                                    'description' => $maintenance_criteria_setup_row['description'],
                                    'data_source' => $maintenance_criteria_setup_row['data_source'],


                                );

                            }
                        }


                    }
                }


            }
        }

    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="container text-center">
            <div class="row">
                <div class="col-auto me-auto">
                    <h4>Maintenance Criteria Setup</h4>
                </div>
                <div class="col-auto"> <a href="add.php" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <?php

        foreach ($data as $key => $rows) { ?>
            <div class="text-center">
                <h5>
                    <?php echo $key; ?>
                </h5>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Indicator</th>
                        <th>Relevant/Definition </th>
                        <th>Minimum Requirements</th>
                        <th>Documentary Requirements/MOVs</th>
                        <th>Data Source</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows as $row) {

                        ?>
                        <tr>
                            <td>
                                <a href="edit.php?edit_id=<?php echo $row['keyctr'] ?>">Edit</a> |
                                <a href="script.php?delete_id=<?php echo $row['keyctr'] ?>">Delete</a>
                            </td>
                            <td><?php echo $row['indicator_code']." ".  $row['indicator_description']; ?></td>
                            <td><?php echo $row['relevance_definition']; ?></td>
                            <td><?php echo $row['reqs_code'] ." ". $row['description']; ?></td>
                            <td><?php echo $row['documentary_requirements']; ?></td>
                            <td><?php echo $row['data_source']; ?></td>
                        </tr>

                        <?php
                    } ?>



                </tbody>
            </table>

            <br />
            <br />


            <?php
        }

        ?>

    </div>
</body>

</html>
