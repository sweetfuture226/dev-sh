@extends('admin.layouts.app')
@section('title', 'Users Management')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users Management </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-12">
              <a href="#"
                 data-toggle="modal"
                 data-target="#ModalAddUser"
                 class="btn btn-primary my-2">Add User</a>
          </div>
         <div class="col-12">
           @livewire('admin.list-users')
         </div>
        </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@push('modals')
  <div class="modal fade" id="ModalAddUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      @livewire('admin.create-user')
    </div>
  </div>

  <div class="modal fade" id="ModalEditUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      @livewire('admin.edit-user')
    </div>
  </div>

@endpush
