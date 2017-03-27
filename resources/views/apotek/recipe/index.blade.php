@extends('layouts.app')
@section('css')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Resep</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="action">
                        <a href="/apotek/resep/tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Resep</a>
                    </div>
                    <table class="table" id="table-recipe">
                        <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Pembeli</td>
                            <td>Nomor Resep</td>
                            <td>Poli / Pembelian Luar</td>
                            <td>Tanggal Transaksi</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection