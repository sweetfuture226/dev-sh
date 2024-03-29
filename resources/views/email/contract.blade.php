<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" charset="utf-8"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
            charset="utf-8"></script>

    <style>
        body {
            font-family: "Nunito", sans-serif;
            font-size: 0.9rem;
            font-weight: 200;
        }

        small, .small {
            font-size: 0.875em;
        }

        h6, .h6, h5, .h5, h4, .h4, h3, .h3, h2, .h2, h1, .h1 {
            margin-top: 0;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: x-large;
        }

        .btn-primary {
            color: #fff !important;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .my-2 {
            margin-top: 0.5rem !important;
            margin-bottom: 0.5rem !important;
        }

        .my-2 {
            margin-top: 0.5rem !important;
            margin-bottom: 0.5rem !important;
        }

        .my-3 {
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .my-4 {
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }

        .p-20 {
            padding: 20px;
        }

        .py-0 {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .w-100 {
            width: 100%;
        }

        .w-40p {
            width: 40%;
        }

        .w-60p {
            width: 60%;
        }

        .mx-w-img {
            max-width: 350px;
        }

        td {
            padding: 0.5rem 0;
        }

    </style>

</head>
<body>
<div class="card p-5 border-light">
    <div class="card-body p-20">
        <div class="row">

            <div class="col-md-12">
                <h1>
                    Please Review the contract #{{$contract->id}}
                </h1>
            </div>

            <div class="col-md-12 mt-3">
                <div class="row py-0">
                    <table class="w-100">
                        <tr>
                            <td class="w-40p">


                                <div>
                                    <a href="{!! route('contracts.show',[$contract->task->id, $contract->id]) !!}" class="btn btn-primary">
                                        Review
                                    </a>
                                </div>

                                <div class="my-4">
                                    <hr>
                                </div>


                                <div class="py-2">
                                    <table class="small text-muted align-middle table-lg table table-borderless">
                                        <tr>
                                            <td style="width: 130px">Task Content</td>
                                            <td>
                                                {!! $contract->task->content !!}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Task Description</td>
                                            <td>
                                                {!! $contract->task->description !!}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Contract Start At</td>
                                            <td>
                                                {!! $contract->start_at !!}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Duration</td>
                                            <td>
                                                {!! $contract->duration !!}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Budget</td>
                                            <td>
                                                ${!! $contract->budget !!}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </td>

                            <td class="w-60p">
                                <img class="mx-lg-5 mx-w-img"
                                     src="{!! asset('images/task-success.png') !!}">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
