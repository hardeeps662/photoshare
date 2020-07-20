<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"> 
            <div class="card">               
                <div class="card-body">
                    <div class="row p-1 d-flex justify-content-center flex-wrap " >
                        <div class="p-2" v-for="album in allAlbums.images">
                            <div style=" border: 1px solid lightgrey; padding: 5px;" >
                                <img class="" :src="'/storage/album_image/'+album.photo" width="170px" height="140px" style="border-radius: 1px;">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="row ml-1 mt-1"><h5 class="mt-1">Created By : <a href="">{{allAlbums.user.name}}</a></h5><button class="btn btn-outline-primary btn-sm ml-3" @click="userFollowUnfollow(allAlbums.user.id)">{{allAlbums.user.followers}}</button></div>
                <h4 class="mt-4">{{allAlbums.name}}</h4> 
                <h5>{{allAlbums.description}}</h5>
            </div>
           <div class="container">
                <div class="row mt-5">
                    <h5 class="">2 Comments</h5>
                    <a href=""> <h5 class="ml-3">Photobook</h5></a>                  
                </div>
                <hr style="border-top: 1.1px solid black" class="mt-1">
           </div>
          <div class=" container">
              <div class="col-md-8 ">
                    <div class="panel panel-info">                       
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-1"> <img src="/storage/album_cover/5f1081503d15d.jpeg" alt="" width="50px" height="44px" class="img-circle">
                                </div>
                                <div class="col-md-11 ">
                                <div class="container">
                                <form id="comment_form" @keydown.enter.exact.prevent="sendMessage">
                                <textarea class="form-control" name="comment" id="text" required placeholder="write a comment..." rows="2" style="border-radius: 15px; height: 45px" ></textarea>
                                <input type="submit" style="display:none;" >
                                </form>
                                </div>
                               </div>
                            </div>
                                                        
                              <div class="clearfix"></div>
                              <hr>
                              <div class="media-list mt-2 " v-for="comment in AllComments" >
                                  <li class="media">
                                    <div class="">
                                      <a href="#" class="">
                                          <img src="/storage/album_cover/5f1081503d15d.jpeg" alt="" width="65px" height="65px" class="img-circle">
                                      </a>
                                      </div>
                                      <div class="container">
                                          <div class="breadcrumb " >
                                           <strong class="text-dark">{{comment.user.name}}</strong>
                                              <span class="text-muted float-right mr-3">
                                                  <small class="text-primary">{{comment.created_at}}</small>
                                              </span>
                                              <p>{{comment.comment}}</p>
                                          </div>
                                      </div>   
                                  </li>
                                   <a class="text-info font-weight-bold" style="margin-left:95px; margin-top:10px;" href="#" @click.prevent="ReplyToComment(comment.id)">Reply</a>
                                   <div class="col-md-12 mt-1" v-if="replyField==comment.id">
                                      <div class="row" >
                                           <div class="" style="margin-left:90px">
                                            <img src="/storage/album_cover/5f1081503d15d.jpeg" alt="" width="40px" height="40px" class="img-circle">
                                           </div>
                                            <div class="ml-2" >
                                                <div class="">
                                                <form :id="'reply_form-'+comment.id" @keydown.enter.exact.prevent="sendReply(comment.id)" >
                                                <textarea class="form-control" name="reply" id="reply_text" placeholder="write a comment..." rows="2" style="border-radius: 15px; height:45px; width: 517px"></textarea>
                                                <input type="submit" style="display:none;" >
                                                </form>
                                                </div>                                            
                                            </div>
                                      </div>
                                   </div>
                                   <div class="media " style="margin-left:90px;margin-top:10px;" v-for="reply in comment.replies">
                                      <div class="media-left">
                                        <img src="http://fakeimg.pl/50x50" class="media-object" style="width:40px">
                                      </div>
                                      <div class="breadcrumb ml-2">
                                        <strong class="media-heading title">{{reply.user.name}}</strong>
                                        <span class="text-muted float-right mr-2">
                                                  <small class="text-primary">{{reply.created_at}}</small>
                                              </span>
                                        <p>{{reply.reply}}</p>
                                      </div>
                                  </div>                               
                                  
                              </div>

                              
                          </div>
                      </div>
                

              </div>
          </div>

        </div>
    </div>
</div>
</template>
<script>
    export default {
        props:['allAlbums'],
        mounted() {
           axios.get('/comment/'+this.allAlbums.id).then(response=>{

           this.AllComments=response.data;  
           //this.AllComments.forEach(element => console.log(element.replies));

           }).catch(error=>{
              console.log(error);
           });
           
        },
        data(){
         return {
            replyField:'',
            AllComments:[],
            AllReply:[],
         }
        },
        methods:{
          userFollowUnfollow(id){

             axios.post('/follow-unfollow/'+id).then(response=>{
                 console.log(response);
             }).catch(error=>{
              console.log(error.response);
             });
          },
          ReplyToComment(id){
             this.replyField=id;
            
          },
          showReply(value){
             axios.get('/reply'+value).then(response=>{
                this.AllReply=response.data;
                
             }).catch(error=>{
                console.log(error.response);
             });
          },
          sendReply(id){
            var form=document.getElementById('reply_form-'+id);
            console.log(form);
            var formdata=new FormData(form);
            formdata.append('album_id',this.allAlbums.id);
            axios.post('/reply/'+id,formdata).then(response=>{
                $('#reply_text').val(""); 
             this.AllComments=response.data;
            }).catch(error=>{
             console.log(error.response);
            });
          },
          sendMessage(){
           var form=document.getElementById('comment_form');
           var formdata=new FormData(form);
           console.log(formdata);
           axios.post('/comment/'+this.allAlbums.id,formdata).then(response=>{
               $('#text').val(""); 
            this.AllComments=response.data[0];
            console.log(this.AllComments);

           }).catch(error=>{
            console.log(error);
           });
          },
        }
        
    }
</script >

<style scoped>
.breadcrumb{
    margin-bottom:.2rem;
    background-color: #e7edee;
    border-radius: 1.5rem;
     padding-top:.5rem; 
     padding-bottom: .01rem; 
     display: block;

}
</style>