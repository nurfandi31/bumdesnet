<!DOCTYPE html>
<html lang="en">

<head>
    <title>Proses Migrasi Data</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="/Login/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/Login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/assets/vendor/fontawesome-free/css/all.min.css">
    <!--===============================================================================================-->
    <style>
        /* Timeline Styling */
        .timeline {
            position: relative;
            padding: 50px 0;
            list-style: none;
        }

        /* Garis tengah */
        .timeline-line {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
            width: 4px;
            background: #ddd;
            transform: translateX(-50%);
        }

        /* Timeline Item */
        .timeline-item {
            position: relative;
            width: 50%;
            padding: 20px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        }

        .timeline-item:nth-child(odd) {
            left: 0;
            text-align: right;
        }

        .timeline-item:nth-child(even) {
            left: 50%;
        }

        /* Titik di timeline */
        .timeline-point {
            position: absolute;
            top: 25px;
            left: 50%;
            width: 20px;
            height: 20px;
            background: white;
            border: 4px solid #57b846;
            border-radius: 50%;
            transform: translateX(-50%);
            z-index: 2;
        }

        /* Box Content */
        .timeline-content {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .timeline-date {
            font-size: 14px;
            font-weight: bold;
            color: #57b846;
            margin-bottom: 8px;
        }

        .timeline-icon {
            font-size: 30px;
            color: #57b846;
            margin-bottom: 10px;
        }

        /* Animasi loading */
        .loading-item {
            text-align: center;
            color: #57b846;
            font-size: 24px;
            margin: 10px 0;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <div class="container pt-3">
        <div class="d-flex justify-content-center">
            <button type="button" id="mulaiMigrasi" class="btn btn-lg btn-success">Mulai Migrasi</button>
        </div>
        <ul class="timeline">
            <div class="timeline-line"></div>
            <div id="timeline-container"></div>
            <div id="loading" class="text-center mt-3"></div>
        </ul>
    </div>

    <!--===============================================================================================-->
    <script src="/Login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="/Login/vendor/bootstrap/js/popper.js"></script>
    <script src="/Login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--===============================================================================================-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const timelineContainer = document.getElementById("timeline-container");
            const loadingIndicator = document.getElementById("loading");

            let index = 0;
            $(document).on('click', '#mulaiMigrasi', function(e) {
                e.preventDefault();
                $('#timeline-container').html('');

                index = 0;
                ajaxRequest('/migrasi/desa')
            })

            function ajaxRequest(url) {
                $.get(url, function(result) {
                    if (result.success) {
                        loadNextItem(result);
                        if (result.next) {
                            if (result.open_tab) {
                                window.open(result.next);
                            } else {
                                ajaxRequest(result.next);
                            }
                        }

                        if (result.finish) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Proses Migrasi Berhasil',
                            }).then(() => {
                                window.location.href = '/register'
                            });
                        }
                    }
                })
            }

            window.addEventListener("message", (event) => {
                const data = event.data;
                if (data.success) {
                    loadNextItem(data);
                    if (data.next) {
                        ajaxRequest(data.next);
                    }
                }
            });

            function loadNextItem(data) {
                const timelineItem = document.createElement("li");
                timelineItem.classList.add("timeline-item");

                if (index % 2 === 0) {
                    timelineItem.style.left = "0";
                    timelineItem.style.textAlign = "right";
                } else {
                    timelineItem.style.left = "50%";
                }

                timelineItem.innerHTML = `
                  <div class="timeline-point"></div>
                  <div class="timeline-content">
                    <div class="timeline-date">${data.time}</div>
                    <h5>${data.msg}</h5>
                  </div>
                `;

                timelineContainer.appendChild(timelineItem);

                setTimeout(() => {
                    timelineItem.style.opacity = "1";
                    timelineItem.style.transform = "translateY(0)";
                }, 100);

                index++;
            }
        });
    </script>
</body>

</html>
