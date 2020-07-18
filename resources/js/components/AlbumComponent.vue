<template>
<div>  
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-11">
          <div v-if="SavedMessage" >
          <div class="alert alert-success">
            {{SavedMessage}}
          </div>
         </div>
        <div class="breadcrumb ">
            <div class="row">
              <h3 style="margin-left:20px">Your Album</h3>
              <button style="margin-left:580px;" type="btn" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
              Create New Album
              </button>
            </div>
        </div>
        <div class="card border-info" >
          <div class="card-body">
            
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>SN</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Images</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(album,index) in albums">
                    <td>{{index+1}}</td>
                    <td><img :src="'storage/album_cover/'+album.image" width="65px" height="65px"></td>
                    <td>{{album.name}}</td>
                    <td>{{album.description}}</td>
                    <td>{{album.category.name}}</td>
                    <td><a :href="'/images/'+album.id+'/create'" class="btn btn-outline-primary">Upload</a></td>
                    <td><div class="dropdown">
                      <a class="btn btn-outline-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </a>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        
                        <button type="button" class="dropdown-item btn btn-outline-primary" data-toggle="modal" @click.prevent="editAlbum(album.id)" data-target="#editForm">Edit</button>
                        <button type="button" class="dropdown-item btn btn-outline-danger" @click.prevent="deleteAlbum(album.id)">Delete</button>
                      </div>
                    </div>
                  </td>

                  </tr>         
                </tbody>
              </table>
             <album-form @message="CreateMsg" @albumOutput="showAlbumData"></album-form>
              <edit-form :FetchData="EditData" @AlbumUpdate="UpdateMsg" @Updated="updateAlbumData"></edit-form>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>
<script>
export default {

data(){
  return{
      id:"",
      EditData:{},
      SavedMessage:'',
      albums:[],
  }
},
mounted(){

  axios.get('/getalbums').then(response=>{
      this.albums = response.data;
      console.log(this.albums);
  }).catch(error=>{
       console.log(error.response);
  });
},
methods:{

  editAlbum(id){        
    axios.get('/album/'+id+'/edit')
      .then(response=> {
        this.EditData = response.data;

      })
      .catch(function (error) {
        // handle error
        console.log(error);
      });
          
    
      },
  CreateMsg(value){
    this.SavedMessage=value;
  },
  showAlbumData(value){
    this.albums=value;

  },
  updateAlbumData(value){
    this.albums=value;
  },
  UpdateMsg(value){
    this.SavedMessage=value;
  },
  upload(id){
    axios.get('/images').then(response=>{

      $('#mainLayout').html(response.data);
    }).catch();
  },
  deleteAlbum(id){

    Vue.swal({
       title: 'Are you sure?',
       text: 'You will not be able to recover this imaginary file!',
       icon: 'warning',
       showCancelButton: true,
       confirmButtonText: 'Yes, delete it!',
       cancelButtonText: 'No, keep it'
     }).then((result) => {
       if (result.value) {
        var formdata = new FormData();
        formdata.append('_method','delete');
         axios.post('/album/'+id,formdata)
           .then(response=> {
             this.SavedMessage = response.data.message;
             this.albums = response.data[0];
           })
           .catch(function (error) {
             // handle error
             console.log(error);
           });

         Vue.swal(
           'Deleted!',
           'Your imaginary file has been deleted.',
           'success'
         )
       // For more information about handling dismissals please visit
       // https://sweetalert2.github.io/#handling-dismissals
       } else if (result.dismiss === Swal.DismissReason.cancel) {
         Vue.swal(
           'Cancelled',
           'Your imaginary file is safe :)',
           'error'
         )
       }
     })
    
  },

  },
}
</script>
<style scoped>
body{
background-color: #f2f7fc;
}
.dropdown .dropdown-menu .dropdown-item:hover{
  background-color: #5db4fc !important;
}
table{
      border-collapse: separate;

}
</style>