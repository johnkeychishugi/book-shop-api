<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Books</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>    
                                    <th>ID</th>
                                    <th>Nane</th>
                                    <th>ISBN</th>
                                    <th>Authors</th>
                                    <th>Country</th>
                                    <th>Number of Page</th>
                                    <th>Publisher</th>
                                    <th>Release Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="books.length > 0">
                                <tr v-for="(book,key) in books" :key="key">
                                    <td>{{ book.id }}</td>
                                    <td>{{ book.name }}</td>
                                    <td>{{ book.isbn }}</td>
                                    <td>
                                        <ul v-for="(author,key1) in book.authors" :key="key1">
                                            <li>{{ author }}</li>
                                        </ul>
                                    </td>
                                    <td>{{ book.country }}</td>
                                    <td>{{ book.number_of_pages }}</td>
                                    <td>{{ book.publisher }}</td>
                                    <td>{{ book.release_date }}</td>
                                    <td>
                                        <router-link :to='{name:"BookEdit",params:{id:book.id}}' class="btn btn-success">Edit</router-link>
                                        <button type="button" @click="deleteBook(book.id)" class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4" align="center">No Books Found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"books",
    data(){
        return {
            books:[]
        }
    },
    mounted(){
        this.getbooks()
    },
    methods:{
        async getbooks(){
            await this.axios.get('/api/v1/books').then(response=>{
                this.books = response.data.data
            }).catch(error=>{
                console.log(error)
                this.books = []
            })
        },
        deleteBook(id){
            if(confirm("Are you sure to delete this Book ?")){
                this.axios.delete(`/api/v1/books/${id}`).then(response=>{
                    this.getbooks()
                }).catch(error=>{
                    console.log(error)
                })
            }
        }
    }
}
</script>
