<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update book</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="update">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" v-model="books.name">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>IBSN</label>
                                    <input type="text" class="form-control" v-model="books.isbn">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" v-model="books.country">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Number of pages</label>
                                    <input type="text" class="form-control" v-model="books.number_of_pages">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Publisher</label>
                                    <input type="text" class="form-control" v-model="books.publisher">
                                </div>
                            </div>
                              <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Release date</label>
                                    <input type="date" class="form-control" v-model="books.release_date">
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"update-books",
    data(){
        return {
            books:{
                name:"",
                country:"",
                isbn:"",
                number_of_pages: 0,
                publisher: "",
                release_date: "",
                authors: "",
            }
        }
    },
    mounted(){
        this.showbooks()
    },
    methods:{
        async showbooks(){
            await this.axios.get(`/api/v1/books/${this.$route.params.id}`).then(response=>{
                const { name, country, isbn, number_of_pages, publisher, release_date, authors } = response.data.data
                this.books.name = name
                this.books.country = country,
                this.books.isbn = isbn,
                this.books.number_of_pages = number_of_pages ,
                this.books.publisher = publisher,
                this.books.release_date = release_date,
                this.books.authors = authors[0]
            }).catch(error=>{
                console.log(error)
            })
        },
        async update(){
            await this.axios.patch(`/api/v1/books/${this.$route.params.id}`,this.books).then(response=>{
                this.$router.push({name:"home"})
            }).catch(error=>{
                if (error.response) {
                   console.log(error.response);
                }
            })
        }
    }
}
</script>