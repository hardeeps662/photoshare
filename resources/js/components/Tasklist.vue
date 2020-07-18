<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task Lisk</div>
                
                <div class="card-body">
                    <ul>
                        <li v-for="task in tasks" :key="task.id"> {{task.task}}</li>
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
tasks:[]
}
},
created() {
var self = this;
axios.get('/api/task')
.then(response=>this.task=response.data)
}

}
</script>