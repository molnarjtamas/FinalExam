<template>
    <div>
        <h3 class="text-gray-700 text-3xl font-medium">Users</h3>

        <div class="mt-4">
            <h4 class="text-gray-600">Registered users</h4>

            <div class="mt-6">
                <div class="bg-white shadow rounded-md overflow-hidden my-6">
                    <table class="text-left w-full border-collapse">
                        <thead class="border-b">
                        <tr>
                            <th
                                class="py-3 px-5 bg-green-800 font-medium uppercase text-sm text-gray-100"
                            >
                                Name
                            </th>
                            <th
                                class="py-3 px-5 bg-green-800 font-medium uppercase text-sm text-gray-100"
                            >
                                Email
                            </th>

                        </tr>
                        </thead>
                        <tbody>
           
                        <tr v-for="user in this.users">

                            <td>{{user.name}}</td>
                            <td>{{user.email}}</td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: "Users",
    data() {
        return {
            users : null
        }
    },
    mounted() {
        this.fetchUsers()
        console.log(this.users)
    },

    methods: {

        fetchUsers() {
            axios.get('http://127.0.0.1:8002/api/users')
                .then(res => {
                   // res = this.users
                  //  console.log(res.data.data,"response")

                    this.users = res.data.data
                    console.log(this.users,"macska")
                }).catch(err => {
                console.log(err)
            })
        }
    }

}
</script>
