@include('includes.header')
<body class="g-sidenav-show  bg-gray-200">

  @include('includes.sidebar')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          
        </div>
        <ul class="navbar-nav  justify-content-end">
          <li class="nav-item d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
              <i class="fa fa-user me-sm-1"></i>
              <span class="d-sm-inline d-none">Welcome back  {{ ucfirst(Auth()->user()->name) }} </span>
            </a>
          </li>
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">Category</h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <a href="{{ '/dashboard' }}" class="btn btn-lg btn-primary mx-3">Add</a>
              <table class="table align-items-center mb-0 text-center">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Slug</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Create Date</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($results as $data)
                  <tr>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $data->categoryName }}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $data->categorySlug }}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $data->categoryImage }}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $data->categoryStatus }}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $data->created_at }}</p>
                    </td>
                    <td class="align-middle">
                      <a href="javascript:;" class="text-success font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        <i class="material-icons text-success me-2">edit</i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Button trigger modal -->

   @include('includes/footer')
  </div>
</main>

