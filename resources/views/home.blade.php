@extends('layouts.app')
@section('css')
    <style>
        .sign-in {
            margin: 15px 0px;
            float: right;
        }

        .log-in {
            margin: 15px;
            float: right;
        }

        .vl {
            border-left: 4px solid rgb(255, 255, 255);
            height: 600px;
        }

        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
        }

    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <form onsubmit="return submitForm(this);" action="{{ route('create_data') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="text-center">
                                    <img id="output"
                                        src="https://cdn.discordapp.com/attachments/841920205743718471/898629358665760779/no-image.jpg"
                                        class="img-thumbnail" style="max-width: 300px; max-height: 300px;" alt="" />
                                </div>
                                <div class="input-group mt-3">
                                    <div class="custom-file">
                                        <input type="file" onchange="loadFile(event)" name="file_image"
                                            class="custom-file-input" id="inputGroupFile02" required />
                                        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <label class="col-form-label" class="text-white" for="start">เลือกวันที่</label>
                                    <div class="form-group">
                                        <input class="form-control" type="date" id="start" name="date" min="2021-01-01"
                                            max="2021-12-31" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="col-form-label" for="distance" class="text-white">กรอกระยะทาง</label>
                                    <div class="input-group">
                                        <input class="form-control" name="distance" id="distance" type="number"
                                            class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default" placeholder="ระยะทาง" required>
                                        <span class="input-group-text" id="inputGroup-sizing-default">Km.</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary float-right my-4 ml-2" onclick="myFunction()"
                                    value="submit">บันทึก</button>
                                <button type="reset" class="btn btn-secondary float-right my-4">รีเซ็ท</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @php
                $i = 1;
            @endphp
            <div class="col-lg-5">
                <div class="card border border-secondary"
                    style="position: relative;
                                                                                                                                                                            max-height: 500px;
                                                                                                                                                                            overflow: auto;">
                    <table class="table  table-striped table-hover">
                        <thead class="bg-light" style="position: sticky;
                                                                                                                top: 0;">
                            <tr>
                                <th scope="col">ครั้งที่</th>
                                <th scope="col"></th>
                                <th scope="col">ชื่อผู้ใช้</th>
                                <th scope="col">ระยะทาง</th>
                            </tr>
                        </thead>
                        <tfoot style="position: sticky;
                                                                                        bottom: 0;
                                                                                        border-top: 2px solid #ccc;">
                            <tr>
                                <th scope="row" class="table-danger"></th>
                                <td class="table-danger"></td>
                                <td class="table-danger">ระยะทางทั้งหมด</td>
                                <td class="table-danger">{{ $sun_number_score }} Km.</td>
                            </tr>
                        </tfoot>
                        <tbody style="overflow-y:scroll; max-height:100px">
                            @foreach ($data as $item)
                                <tr>
                                    <th scope="row">{{ $i++ }}</th>
                                    <td><i class="fas fa-user" style="font-size:20px"></i></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->number_score }} Km.</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
        integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous">
    </script>
    <script type="application/javascript">
        $('input[type="file"]').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
    </script>
    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
    <script>
        function submitForm() {
            return confirm('Do you really want to submit the form?');
        }
    </script>
@endsection
