<template>
    <div>
        <h2>Profiles</h2>
        <!-- form for add and edit -->
        <form @submit.prevent="addProfile" class="mb-3">
            <div class="form-gorup">
                <input type="text" class="form-control" placeholder="Lastname"
                v-model="profile.last_name">
            </div> 
            <div class="form-gorup">
                <input type="text" class="form-control" placeholder="Firstname"
                v-model="profile.first_name">
            </div>
            <div class="form-gorup">
                <input type="text" class="form-control" placeholder="Course"
                v-model="profile.course">
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>  
        </form>
        <!-- form for add and edit -->

        <!-- Pageination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
            <a class="page-link" href="#" @click="fetchProfiles(pagination.prev_page_url)">Previous</a>
            </li>
            <li class="page-item disabled"><a class="page-link text-dark"
             href="#">Page {{pagination.current_page}} of {{ pagination.last_page }}</a></li>
            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
            <a class="page-link" href="#" @click="fetchProfiles(pagination.next_page_url)">Next</a>
            </li>
            </ul>
        </nav>
        <!-- Pagination -->

        <!-- Data View -->
        <div class="card card-body mb-2" v-for="profile in profiles" v-bind:key="profile.id">
            <td>Last Name: {{ profile.last_name }}</td>
            <td>First Name: {{ profile.first_name }}</td>
            <td>Course: {{ profile.course }}</td>
            <hr>
            <td>
            <button @click="editProfile(profile)" class="btn btn-warning">Edit</button>
            <button @click="deleteProfile(profile.id)" class="btn btn-danger">Delete</button>
            </td>
        </div>
    </div>
    <!-- Data view -->
</template>

<script>
export default {
    data() {
        return{
            profiles: [],
            profile: {
                id: '',
                first_name: '',
                last_name: '',
                course: ''
            },
            profile_id: '',
            pagination: {},
            edit: false
        }
    },
    created() {
        this.fetchProfiles();
    },
    methods: {
        // pagination fetch
        fetchProfiles(page_url) {
            let vm = this;
            page_url = page_url || '/api/profiles'
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.profiles = res.data;
                vm.makePagination(res.meta, res.links);
            })
            .catch(err => console.log(err));
        },
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }

            this.pagination = pagination;
        },

        // delete profile
        deleteProfile(id) {
            if(confirm('Delete File?')) {
                fetch(`api/profile/${id}`, {
                    method: 'delete'
                })
                .then(res => res.json())
                .then(data => {
                    alert('Profile Deleted');
                    this.fetchProfiles();
                })
                .catch(err => console.log(err));
            }
        },

        addProfile() {
            //add profile
            if(this.edit == false) {
                fetch('api/profile',{
                    method: 'post',
                    body: JSON.stringify(this.profile),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.profile.last_name = '';
                    this.profile.first_name = '';
                    this.profile.course = '';
                    alert('Profile Added');
                    this.fetchProfiles();
                })
                .catch(err => console.log(err));
            } else {
                //update profile
                 fetch('api/profile',{
                    method: 'put',
                    body: JSON.stringify(this.profile),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    this.profile.last_name = '';
                    this.profile.first_name = '';
                    this.profile.course = '';
                    alert('Profile Updated');
                    this.fetchProfiles();
                })
                .catch(err => console.log(err));

            }
        },
        // edit profile
        editProfile(profile) {
            this.edit = true;
            this.profile.id = profile.id;
            this.profile.profile_id = profile.id;
            this.profile.first_name = profile.first_name;
            this.profile.last_name = profile.last_name;
            this.profile.course = profile.course;
        }


    }
}
</script>