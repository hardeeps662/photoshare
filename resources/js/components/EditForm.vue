<template>
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="editFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFormLabel">Edit Album</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
          
          <div v-show="isActive" class="container mt-1">
              <ul class="alert alert-danger ">
                  <li v-for="error in ValidateErrors">{{error[0]}}</li>
              </ul>  
          </div>
                 
            <form @submit.prevent="onUpdate()" enctype="multipart/form-data" id="UpdateForm" >
                <div class="modal-body">
                    <div class="form-group">
                       <label for="name">Name</label>
                       <input  type="text" class="form-control" id="name" name="name" v-model="FetchData.name" placeholder="Enter name" >
                        
                    </div>
            
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" rows="2"  v-model="FetchData.description" name="description" id="description"></textarea>
                         <span v-if="ValidateErrors.description" class="text-danger">{{ValidateErrors.description[0]}}</span>
                    </div>
                    <div class="form-gropu">
                        <input type="file" id="customFile"  v-validate="'required|ext:jpeg,jpg,png'"  data-vv-as="field" name="file" class="form-control" @change="uploadFile">
                         <span v-show="errors.has('file')" class="text-danger">{{ errors.first('file') }}</span>
                      
                    </div>
                    
                    <div class="form-group mt-4">
                        <label for="category">Select Category</label>
                        <select name="category" class="custom-select"  v-validate="'required'" data-vv-as="selected" v-model="FetchData.category_id">
                            <option value="" selected disabled hidden>Please select category</option>
                            <option  v-for="(category,index) in AllCategory" :value="category.id">{{ category.name }}</option>
                            
                        </select>
                         <span v-show="errors.has('category')" class="text-danger">{{ errors.first('category') }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="update_form" class="btn btn-primary" >Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 
                </div>
                
            </form>
            
        </div>
    </div>
  
</div>
</template>
<script>

export default {
    props: ['Mycategories','FetchData'],

  mounted() {
   

  },
  created() {

   axios.get('/api/album/all/category')
     .then(response=> {
       this.AllCategory = response.data;

     })
     .catch(function (error) {
       // handle error
       console.log(error);
     });

  },
  
  data(){
    return{
       name:"",
       description:"",
       file:"",
       category:"",
       AllCategory:[],
       ValidateErrors:[],
       isActive:false,
       successMsg:"",
    }
  },
  methods:{
    uploadFile(event){
     this.file=event.target.files[0];
    },
    onUpdate(){
      var form=document.getElementById('UpdateForm');
       var id=this.FetchData.id;
       var formdata=new FormData(form);
       formdata.append('_method','PUT');

         axios.post('/album/'+id,formdata)
                .then(response => {           
                  this.successMsg=response.data.message;
                  this.updateData=response.data[0];
                  this.$emit('AlbumUpdate', this.successMsg);
                   this.$emit('Updated', this.updateData);
                  $('#editForm').modal('hide');  
                }).catch(error => {
                   if (error.response.status === 422) {
                       this.ValidateErrors = error.response.data.errors;
                        this.isActive=true;  
                        console.log(error.response.data.errors);
                   }
                   
                  });
    },
   
  }
}
</script>