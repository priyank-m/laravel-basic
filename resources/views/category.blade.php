@include('includes.header')
<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }
  
  .switch input { 
    opacity: 0;
    width: 0;
    height: 0;
  }
  
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }
  
  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }
  
  input:checked + .slider {
    background-color: #2196F3;
  }
  
  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }
  
  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }
  
  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }
  
  .slider.round:before {
    border-radius: 50%;
  }
  </style>
  
<meta name="csrf-token" content="{{ csrf_token() }}">
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
              <div class="alert alert-danger alert-dismissible text-white d-none" role="alert" id="delete_div">
                <span class="text-sm" id="delete_message"></span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div> 
              <a href="#" class="btn btn-lg btn-primary mx-3" style="float: right" id="categoryadd">Add</a>
              
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
                      <img src="{{ $data->categoryImage }}" alt="preview image" style="max-height: 100px;max-width: 100px;">
                      {{-- <p class="text-xs font-weight-bold mb-0">{{ $data->categoryImage }}</p> --}}
                    </td>
                    <td>
                      @if($data->categoryStatus == 1)
                      <p class="text-xs font-weight-bold mb-0">Active</p>
                      @else
                      <p class="text-xs font-weight-bold mb-0">Inactive</p>
                      @endif
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">{{ $data->created_at }}</p>
                    </td>
                    <td class="align-middle">
                      <a href="javascript:void(0)" data-id="{{ $data->id }}" class="btn btn-success edit-category"><i class="material-icons">edit</i></a>
                      <a href="javascript:void(0)" data-id="{{ $data->id }}" class="btn btn-danger delete-category"><i class="material-icons">delete</i></a>
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
{{-- modal --}}
<div id="myModal" class="modal fade myModal" tabindex="-1">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Category</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <form role="form" id="categoryform" method="post" enctype="multipart/form-data" class="text-start categoryform" action="javascript:void(0)">
          <div class="modal-body">
                            <div class="alert alert-danger alert-dismissible text-white d-none" role="alert" id="msg_div">
                              <span class="text-sm" id="res_message"></span>
                              <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div> 

            <div class="row">
              <div class="col-12 my-3">
                <div class="form-group">
                  <input type="text"  hidden name="id" id="categorySlug">
                  <label>Name:</label>
                  <input type="email" class="form-control categoryName" id="categoryName" placeholder="Name" name="categoryName">
                </div>
              </div>
              <span class="errorMessage" role="categoryName"></span>
              <div class="col-12 my-3">
                <div class="form-group">
                  <label>Image:</label><br/>
                  <input type="file" class="form-control-file" id="categoryImage" name="categoryImage">
                </div>
                <div class="col-md-12">
                  <img id="image_preview_container" class="categoryImage" src="{{ '/' }}backend/assets/img/category/image-preview.png"
                      alt="preview image" style="max-height: 150px;">
                </div>
              </div>
              <span class="errorMessage" role="categoryImage"></span>
              <div class="col-12 my-3">
                <div class="form-group">
                  <label>Status</label><br/>
                    <label class="switch">
                      <input type="checkbox" checked class="categoryStatus" name="categoryStatus" id="categoryStatus">
                      <span class="slider round"></span>
                    </label>
                </div>
              </div>
              <span class="errorMessage" role="categoryStatus"></span>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary close" data-dismiss="modal">Cancel</button>
              <button type="submit" id="categorybtn" class="btn btn-primary"><div class="spinner-border d-none" style="width: 1.3rem;height: 1.3rem"></div><span class="categoryspinner">Save</span></button>
          </div>
        </form>
      </div>
  </div>
</div>
<script>
  $(document).ready(function(){
      $("#categoryadd").click(function(){
          $("#myModal").modal('show');
      });
      $(".close").click(function(){
          $("#myModal").modal('hide');
      });
  });
</script>
{{-- AJAX Insert --}}
<script>
  //-----------------
$(document).ready(function(){

    $('#categoryImage').change(function(){
          
          let reader = new FileReader();
          reader.onload = (e) => { 
            $('#image_preview_container').attr('src', e.target.result); 
          }
          reader.readAsDataURL(this.files[0]); 

    });

  $('#categorybtn').click(function(e){
       e.preventDefault();


      $('.categoryspinner').addClass('d-none');
      $('.spinner-border').removeClass('d-none');
        
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var formData = new FormData($('.categoryform')[0]);

      $('.errorMessage').html('')
      $.ajax({
      url: '/category',
      method: 'post',
      data: formData,
      cache:false,
      contentType: false,
      processData: false,
      success: function(response){
         //------------------------
         if (response.status == true) { // If success then redirect to login 
          $('#msg_div').hide(); 
          $(".myModal").modal('hide');
          window.location = response.redirect_location;
        }

         if (response.status == 400) {
          $(".myModal").modal('show');
          $('.categoryspinner').removeClass('d-none');
          $('.spinner-border').addClass('d-none'); 
          var test = response.errors;
          jQuery.each(test, function(key, value){
            $("[role='" + key + "']").append("<small class='text-danger'>" + value + "</small>");
          });
         }else{
            $(".myModal").modal('show');
            $('.categoryspinner').removeClass('d-none');
            $('.spinner-border').addClass('d-none');
            $('#res_message').show();
            $('#res_message').html(response.msg);
            $('.name_error').html();
            $('#msg_div').removeClass('d-none');
 
            document.getElementById("loginform").reset(); 

         //--------------------------
         }
      }});
      
      
     });
  });
  //-----------------
  </script>
  <script>
  $('.edit-category').click(function(e){
       e.preventDefault();

       $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

       var id = $(this).data('id');
       //alert(slug)
       $(".myModal").modal('show');

      $.ajax({
      url: '/category/edit',
      method: 'get',
      data: {id: id},
      success: function(response){
         $(".categoryName").val(response.categoryName);
         $(".categoryImage").attr("src",response.categoryImage);
         $("#categorySlug").val(response.id);

         if(response.categoryStatus == 0){
          $('#categoryStatus').prop('checked', false);
         }else{
          $('#categoryStatus').prop('checked', true);

         }
      }});

  });       
  </script>
    <script>
      $('.delete-category').click(function(e){
        if(confirm("Are you sure delete this category")){
           e.preventDefault();
    
           $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
    
           var id = $(this).data('id');
    
          $.ajax({
          url: '/category/delete',
          method: 'get',
          data: {id: id},
          success: function(response){

            if (response.status == true) { // If success then redirect to login 
              window.location = response.redirect_location;
            }else{
            $('#delete_div').removeClass('d-none');
            $('#delete_message').show();
            $('#delete_message').html(response.msg);
            }
          }});
        }
      });       
      </script>


