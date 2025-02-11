<?php require_once('config/database.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />

    <style>
        .filepond--drop-label {
            color: #4c4e53;
        }

        .filepond--label-action {
            text-decoration-color: #babdc0;
        }

        .filepond--panel-root {
            background-color: #edf0f4;
        }
    </style>

</head>

<body>

    <div class="container mt-5">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addLeadModal">Add Lead</button>
        <a class="btn btn-primary mb-3" href="dashboard.php">Dashboard</a>

        <h2>Lead List</h2>

        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by Lead Number or Customer Name">
        </div>

        <table class="table table-bordered" id="leadTable">
            <thead>
                <tr>
                    <th>Lead Number</th>
                    <th>Customer Name</th>
                    <th>Contact No</th>
                    <th>Project Name</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $limit = 5;
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $start = ($page - 1) * $limit;

                $stmt = $conn->prepare("SELECT * FROM leads LIMIT :start, :limit");
                $stmt->bindParam(':start', $start, PDO::PARAM_INT);
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['lead_number'] . "</td>";
                    echo "<td>" . $row['customer_name'] . "</td>";
                    echo "<td>" . $row['contact_no'] . "</td>";
                    echo "<td>" . $row['project_name'] . "</td>";
                    echo "<td><button class='btn btn-info btn-sm view-details' data-lead-id='" . $row['lead_id'] . "'>View Details</button></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        $stmt = $conn->query("SELECT COUNT(*) FROM leads");
        $total = $stmt->fetchColumn();
        $pages = ceil($total / $limit);
        ?>

        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
            </ul>
        </nav>
    </div>

    <div class="modal fade" id="leadDetailsModal" tabindex="-1" aria-labelledby="leadDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadDetailsModalLabel">Lead Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="lead-details"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addLeadModal" tabindex="-1" aria-labelledby="addLeadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLeadModalLabel">Add New Lead</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addLeadForm" method="POST" enctype="multipart/form-data" action="save-leads.php">

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact_no" class="form-label">Contact No</label>
                            <input type="text" class="form-control" id="contact_no" name="contact_no" required>
                        </div>
                        <div class="mb-3">
                            <label for="project_name" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="project_name" name="project_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="flat_details" class="form-label">Flat Details</label>
                            <textarea class="form-control" id="flat_details" name="flat_details" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="property_cost" class="form-label">Property Cost</label>
                            <input type="number" class="form-control" id="property_cost" required name="property_cost">
                        </div>

                        <div class="mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" required>
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>

                        <div class="mb-3">
                            <label for="loan_amount" class="form-label">Loan Amount</label>
                            <input type="number" class="form-control" id="loan_amount" name="loan_amount" required>
                        </div>
                        <div class="mb-3">
                            <label for="rate_of_interest" class="form-label">Rate of Interest</label>
                            <input type="number" class="form-control" id="rate_of_interest" name="rate_of_interest" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="tenor" class="form-label">Tenor (Months)</label>
                            <input type="number" class="form-control" id="tenor" name="tenor" required>
                        </div>
                        <div class="mb-3">
                            <label for="emi" class="form-label">EMI</label>
                            <input type="number" class="form-control" id="emi" name="emi" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control filepond" id="images" name="images[]" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div id="responseMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            FilePond.registerPlugin(FilePondPluginImagePreview);

            const pond = FilePond.create(document.querySelector('.filepond'), {
                allowMultiple: true,
                instantUpload: false,
                onaddfilestart: () => console.log('File added'),
                onprocessfile: (error, file) => console.log(error, file)
            });

            var currentPage = 1;

            function fetchLeads(page) {
                var searchQuery = $('#searchInput').val().toLowerCase();

                $.ajax({
                    url: 'ajax/search-leads.php',
                    type: 'GET',
                    data: {
                        search_query: searchQuery,
                        page: page
                    },
                    success: function(data) {
                        var response = JSON.parse(data);
                        $('#leadTable tbody').html(response.results);

                        $('.pagination').html(response.paginationHTML);
                    },
                    error() {
                        alert('Error fetching search results.');
                    }
                });
            }

            fetchLeads(currentPage);

            $('#searchInput').on('input', function() {
                currentPage = 1;
                fetchLeads(currentPage);
            });

            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                if (page && page !== currentPage) {
                    currentPage = page;
                    fetchLeads(currentPage);
                }
            });

            $(document).on('click', '.view-details', function() {
                var leadId = $(this).data('lead-id');
                $.ajax({
                    url: 'ajax/get-lead-details.php',
                    type: 'GET',
                    data: {
                        lead_id: leadId
                    },
                    success: function(data) {
                        $('#lead-details').html(data);

                        var leadModal = new bootstrap.Modal(document.getElementById('leadDetailsModal'));
                        leadModal.show();
                    },
                    error() {
                        alert('Error fetching lead details.');
                    }
                });
            });

            $('#addLeadForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var form = $(this);

                const files = pond.getFiles();

                files.forEach(function(fileItem) {
                    formData.append('images[]', fileItem.file);
                });

                $.ajax({
                    url: 'ajax/save-leads.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success(data) {

                        var response = JSON.parse(data);

                        console.log(response);

                        if (response.status === true) {
                            $('#responseMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                            form[0].reset();
                            var page = form.data('page');
                            fetchLeads(currentPage);

                            setTimeout(() => {
                                var leadModal = new bootstrap.Modal(document.getElementById('addLeadModal'));
                                leadModal.hide();

                                $('#addLeadModal').hide();
                                $(".modal-backdrop").hide();

                            }, 2000);
                        } else {
                            $('#responseMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }

                    },
                    error(err) {

                        try {
                            var response = JSON.parse(err.responseText);
                            if (response && response.message) {
                                $('#responseMessage').html(`<div class="alert alert-danger">${response.message}</div>`);
                            } else {
                                $('#responseMessage').html('<div class="alert alert-danger">An unknown error occurred.</div>');
                            }
                        } catch (e) {
                            $('#responseMessage').html('<div class="alert alert-danger">Error parsing response.</div>');
                        }

                    }
                });
            });

        });
    </script>


</body>

</html>