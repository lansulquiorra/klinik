@extends('layouts.app')
@section('content')
    <div class="container" style="text-align: justify">
        <div class="ui breadcrumb">
            <div class="section">Admin</div>
            <div class="divider"> / </div>
            <div class="active section">Tindakan</div>
        </div><br/>
        <hr/>
        <div class="action" style="margin-bottom: 10px">
            <a href="{{url('/admin/tindakan/create')}}" type="button"  class="btn btn-primary">Tambah Tindakan</a>
        </div>
        <table id="table-service" class="ui celled table dataTable responsive" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Tindakan</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.btn-remove', function () {
                $this = $(this);
                var $id = $this.data('id');
                if (confirm('Apakah anda yakin akan menghapus postingan ini?')) {
                    var $form = $('<form />');
                    $form.attr('action', '/admin/tindakan/delete');
                    $form.attr('method', 'post');
                    $form.css({
                        'display': 'none'
                    });
                    //csrf
                    var csrf = $('<input />');
                    csrf.attr('type', 'hidden');
                    csrf.attr('name', '_token');
                    csrf.val($('meta[name="csrf-token"]').attr('content'));
                    $form.append(csrf);
                    //id
                    var id = $('<input />');
                    id.attr('type', 'hidden');
                    id.attr('name', 'id');
                    id.val($id);
                    $form.append(id);
                    $('body').append($form);
                    $form.submit();
                }
            });
        });
    </script>
@endsection
