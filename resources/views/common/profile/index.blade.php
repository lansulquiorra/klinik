@extends('layouts.app')
@section('css')
    <link href="{{asset('css/croppie.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Profil</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" class="form-horizontal" action="{{url('/'.$role.'/profil')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="user_id" value="{{$user->id}}">

                        <div class="form-group">
                            <div class="col-md-6 col-lg-offset-3">
                                <div id="upload-demo">
                                    {!! $user->staff && $user->staff->image_profile ? '<img src="'.asset($user->staff->image_profile ).'">' : ''!!}
                                </div>
                                <input type="hidden" name="picture" class="picture">
                                <button type="button" class="result" style="display: none">Crop</button>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Foto Profil</label>
                            <div class="col-md-10">
                                <input type="file" name="file" class="form-control" id="upload"
                                       value="Choose a file"
                                       accept="image/*">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nik"
                                       value="{{$user->staff ? $user->staff->nik : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="full_name"
                                       value="{{$user->staff ? $user->staff->full_name : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tempat / Tanggal Lahir</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="place" value="{{$user->staff ? $user->staff->place : ''}}">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control datetime" name="birth"
                                       value="{{$user->staff ? $user->staff->birth : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="address">{{$user->staff ? $user->staff->address : ''}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Agama</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="religion">
                                    @foreach(getReligions() as $religion)
                                        <option value="{{$religion}}" {{$user->staff && ($religion == $user->staff->religion) ? 'selected' : ''}}>{{$religion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="gender">
                                    @foreach(getGenders() as $gender)
                                        <option value="{{$gender}}" {{ $user->staff && ($gender == $user->staff->gender) ? 'selected' : ''}}>{{$gender == 'male' ? 'Laki-laki' : 'Perempuan'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Provinsi / Kota</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="province" id="province">
                                    @foreach(getProvinceCities() as $province => $arrayCities)
                                        <option value="{{$province}}" {{$user->staff && ($province == $user->staff->province) ? 'selected' : ''}}>{{$province}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <select class="form-control m-b" name="city" id="city">
                                    <option>-</option>
                                    @if($user->staff && $user->staff->city)
                                        @foreach(getProvinceCities()[$user->staff->province] as $city)
                                            <option value="{{$city}}" {{$user->staff && ($city == $user->staff->city) ? 'selected' : ''}}>{{$city}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kecamatan / Kelurahan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="district"
                                       value="{{$user->staff ? $user->staff->district : ''}}">
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="sub_district"
                                       value="{{$user->staff ? $user->staff->sub_district : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Dusun /RT/RW</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="rt_rw" value="{{$user->staff ? $user->staff->rt_rw : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nomor Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="phone_number"
                                       value="{{$user->staff ? $user->staff->phone_number : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Pendidikan</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="last_education">
                                    @foreach(getEducations() as $education)
                                        <option value="{{$education}}" {{$user->staff && ($education == $user->staff->last_education) ? 'selected' : ''}}>{{$education}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-5">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <a href="/{{$role}}" class="btn btn-white" type="button">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('js/province.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/exif.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/croppie.min.js')}}"></script>
    <script>
        $('.datetime').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        function crop() {
            $uploadCrop = $('#upload-demo').croppie({
                enableExif: true,
                showZoomer: true,
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle'
                },
                boundary: {
                    width: 300,
                    height: 300
                }
            });
        }


        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    $uploadCrop.croppie('bind', {
                        url: e.target.result
                    });
                };

                reader.readAsDataURL(input.files[0]);
            }
            else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $(document).ready(function () {
            $('#upload').on('change', function () {
                readFile(this);
                $('#upload-demo').html('');
                crop();
                $('.result').css('display', 'block');
            });
            $('.result').on('click', function (ev) {
                $this = $(this);
                $uploadCrop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport',
                    format: 'png',
                    circle: true
                }).then(function (resp) {
                    var img = '<img src="' + resp + '">'
                    $('#upload-demo').html('');
                    $('#upload-demo').append(img);
                    $('.picture').val(resp);
                    $this.css('display', 'none');
                });
            });
        });
    </script>
@endsection