<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                   <div class=" breadcrumb" style="height:50px; font-size:20px"><dt>WELCOME TO PHOTOBOOK APP</dt></div>
                    <div class="card-header " style="background-color: #535e50">
                        <img src="/storage/image/rebound.jpg" width="1000" height="300" style="  display: block; margin-left: auto; margin-right: auto;">
                    </div>
                 <div class="card">
                    <div class="card border-info">
                       <div class="row p-2 d-flex justify-content-center flex-wrap " >
                        <div class="p-3" v-for="album in allAlbums">
                        <div style=" border: 1px solid lightgrey; padding: 5px;" >
                            <img class="" :src="'/storage/album_cover/'+album.image" width="210px" height="170px" style="border-radius: 1px;">
                            <div class="font-weight-bold text-center mt-3" style="color:#434d57;font-size:17px">{{album.name}}</div >
                            <div class="mt-2 text-center"><a :href="'/user-album/'+album.id" class="btn btn-primary btn-sm">View Album</a>
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
            console.log('Component mounted.')
        }
    }
</script>
