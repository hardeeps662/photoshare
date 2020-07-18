<template>
  <div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Album</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
          
          <div v-show="isActive" class="container mt-1">
              <ul class="alert alert-danger ">
                  <li v-for="error in ValidateErrors">{{error[0]}}</li>
              </ul>  
          </div>
                 
            <form v-on:submit.prevent="onSubmit()" enctype="multipart/form-data" id="userform" >
                <div class="modal-body">
                    <div class="form-group">
                       <label for="name">Name</label>
                       <input  type="text" class="form-control" v-validate="'required|min:3|max:25'" id="name" name="name" v-model="name" placeholder="Enter name">
                         <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span>
                    </div>
            
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" rows="2"  v-model="description" name="description" id="description"></textarea>
                         <span v-if="ValidateErrors.description" class="text-danger">{{ValidateErrors.description[0]}}</span>
                    </div>
                    <div class="form-group">
                        <input type="file" id="customFile"  v-validate="'required|ext:jpeg,jpg,png'" data-vv-as="field" name="file" class="form-control" @change="uploadFile" ref="myFileInput">
                         <span v-show="errors.has('file')" class="text-danger">{{ errors.first('file') }}</span>
                      
                    </div>
                    
                    <div class="form-group mt-4">
                        <label for="category">Select Category</label>
                        <select name="category" class="custom-select"  v-validate="'required'" data-vv-as="selected" v-model="category">
                            <option  value="" disabled selected hidden >Please select category</option>
                            <option  v-for="(category,index) in AllCategory" :value="category.id">{{ category.name }}</option>
                            
                        </select>
                        <span v-show="errors.has('category')" class="text-danger">{{ errors.first('category') }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit_form"class="btn btn-primary" >Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                
            </form>
           
        </div>
    </div>

</div>
 </div>
</template>
<script>

export default {
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
       ValidateErrors:[],
       isActive:false,
       successMsg:"",
       albumData:"",
       AllCategory:[],
    }
  },
  methods:{
    uploadFile(event){
     this.file=event.target.files[0];
    },
    onSubmit(){
        //var form = document.getElementById('userform');
       this.$validator.validateAll().then((result) => {
        if (result) {
          
            var data = new FormData();
            data.append('file',this.file);
            data.append('name',this.name);
            data.append('description',this.description);
            data.append('category',this.category);


            axios.post('/album',data)
                .then((response) => {
                  console.log(response.data.message);
                    this.ValidateErrors=[];
                    this.isActive=false;
                    this.name="",
                    this.description="",
                    this.file="",
                    this.category="",
                    this.$refs.myFileInput.value = '';
                    this.successMsg=response.data.message;
                    this.albumData=response.data[0];
                    this.$emit('message', this.successMsg);
                    this.$emit('albumOutput', this.albumData);
                    $('#exampleModal').modal('hide');             

                }).catch(error => {
                    if (error.response.status === 422) {
                        this.ValidateErrors = error.response.data.errors;
                         this.isActive=true;  

                    }
                 

                  });

            alert('Form Submitted!');
            return;
        }

        alert('Correct them errors!');
      });

        
    }
  }
}
</script>