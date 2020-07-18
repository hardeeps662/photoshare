<template>
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Task Form</div>
                    <div class="card-body">
                        <form action="./api/task" method="post" @submit.prevent="add()">

                         <div class="form-group">
                             <label for="task">Task:</label>
                             <input type="text" v-model="task" class="form-control" name="task" id="task">
                         </div>
                          <button type="submit" class="btn btn-info">Submit</button>
                        </form>
                    </div>
                </div>      
            </div>
        </div>           
            <div class="row justify-content-center" >
               <div class="col-md-8">
                  <div class="card">
                     <div class="card-header">Task list</div>
                     <div class="card-body">
                       <ul>
                        
                        <li v-for="t in tasks" :key="t.id"> {{t.task}}<button type="button" class="btn-info" @click="editData()">Edit</button></li>
                       </ul>
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
          task:'',
          tasks:[],

         }
      },
               mounted() {
             
        },
      methods:{
        add(){
          axios.post('/api/task', {
              task:this.task
            })
            .then(response=>this.tasks=response.data); 
        },

        editData(){

          axios.get('/api/task')
          .then(response);
          console.log(response)
        },
      }  
       
    }
</script>

