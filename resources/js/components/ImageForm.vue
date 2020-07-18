<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div v-if="validationError">
                    <div class="alert alert-danger">
                        <li v-for="error in validationError">{{error[0]}}</li>
                    </div>
                </div>
                <div v-if="successmsg">
                    <div class="alert alert-danger">
                        {{successmsg}}
                    </div>
                </div>
                <div class="breadcrumb">
                    <div class="row">
                       <div class="ml-3" style="font-size:20px">Select Images <h6>(can attach more than one):&nbsp</h6></div>
                       <form class="form-inline" id="imageForm" enctype="multipart/form-data">
                         <div class="form-group">
                           <input type="file" class="form-control" name="file[]"  ref="myFileInput" multiple>
                         </div>&nbsp &nbsp &nbsp
                         <div class="form-group ml-5">
                             <button type="submit" class="btn btn-outline-primary btn-md" @click.prevent="uploadImages">Upload</button>
                         </div>
                       </form>

                    </div>   
                </div>
                <div style="display:none" id="progress">
                    <div class="progress">
                      <div class="progress-bar" id="progress_bar"style="width:0%">1%</div>
                    </div>
                </div>
                <div class="card"  v-if="images.length">
                    <div class=" row p-2 d-flex justify-content-center flex-wrap ">
                        <div class="p-3" v-for="image in images">  
                           
                            <img :src="'/storage/album_image/'+image.photo" width="150px" height="150px">    
                            <div class="mt-1"><button  class="btn btn-outline-danger btn-sm" @click.prevent="deleteImage(image.id)">Delete</button>
                            </div>
                        </div>                      
                    </div>
                    
                </div>
                  <h5 v-else>No Images Upload Yet</h5>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['id'],
        mounted() {
          axios.get('/images/'+this.id).then(response=>{
                this.images=response.data;
                console.log(this.images);
          }).catch(error=>{
              console.log(error.response);
          });
        },
        data(){
            return{
               validationError:"",
               successmsg:"",
               percentage:"",
               images:"",
            }
        },
        methods:{

            deleteImage(id){
              axios.post('/image/'+id+'/delete').then(response=>{
                 this.successmsg=response.data.message;
              }).catch(error=>{

                  console.log(error.response);
              });
            },
          uploadImages(event){
            if(this.$refs.myFileInput.value) {
            $('#progress').show();
            }
            var data= document.getElementById('imageForm');
            var formdata=new FormData(data);
            axios.post('/images/'+this.id,formdata,{
              

               onUploadProgress:function(value){
                this.percentage=parseInt(Math.round((value.loaded/value.total)*100));
                document.getElementById('progress_bar').innerText=this.percentage+'%';
                $('#progress_bar').css('width',this.percentage+'%');
            }

            }).then(response=>{
                this.validationError="";
                this.$refs.myFileInput.value = '';
                 $('#progress').hide();
                this.successmsg=response.data.message;
                this.images=response.data[0];
                
            }).catch(error=>{
                this.validationError=error.response.data.errors;
            });
          }
        },
    }

   
</script>
