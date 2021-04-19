<template>

    <div class="mt-8">


        <div class="mt-6">
            <div class="lg:flex justify-between ">
                <div class=" flex pl-6">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <UsersLogo class=" self-center block h-24 sm:h-44 w-auto"/>
                    </div>
                    <div class="self-center text-5xl ml-8 sm:ml-16 font-semibold text-gray-600 uppercase">
                        Users
                    </div>
                </div>

                <div  v-can="'invite-users'">
                    <InviteUser></InviteUser>
                </div>
            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div
                    class="inline-block min-w-full shadow rounded-lg overflow-hidden"
                >
                    <table class="min-w-full leading-normal">
                        <thead class="border-green-700 bg-green-700 text-white  text-left text-xs sm:text-sm font-semibold uppercase tracking-wider">
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2"
                            >
                                User
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 "
                            >
                                Email
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 hidden sm:table-cell"
                            >
                                Registered
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 hidden sm:table-cell"
                            >
                                Role
                            </th>
                        </tr>
                        </thead>
                        <tbody class="text-xs sm:text-lg">

                        <tr v-for="user in users">
                            <td v-if="user"
                                class="px-2 py-5 "
                            >
                                <div class="flex items-center">
                                    <div v-if="user.profile_photo_path === '/storage/' "
                                         class="flex-shrink-0 w-7 h-7 lg:w-10 lg:h-10">
                                        <svg width="32px" height="32px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <g id="avatar" transform="translate(-1407 -182)">
                                                <circle id="Ellipse_16" data-name="Ellipse 16" cx="15" cy="15" r="15" transform="translate(1408 183)" fill="#e8f7f9" stroke="#333" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                                <g id="Group_49" data-name="Group 49">
                                                    <circle id="Ellipse_17" data-name="Ellipse 17" cx="4.565" cy="4.565" r="4.565" transform="translate(1418.435 192.13)" fill="#fff1b6" stroke="#333" stroke-miterlimit="10" stroke-width="2"/>
                                                    <path id="Path_53" data-name="Path 53" d="M1423,213a14.928,14.928,0,0,0,9.4-3.323,9.773,9.773,0,0,0-18.808,0A14.928,14.928,0,0,0,1423,213Z" fill="#fff1b6" stroke="#333" stroke-miterlimit="10" stroke-width="2"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div v-else class="flex-shrink-0 w-7 h-7 lg:w-10 lg:h-10">
                                        <img
                                            class="w-full h-full rounded-full"
                                            :src="user.profile_photo_path"
                                        />
                                    </div>

                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            {{ user.name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td v-if="user" class="py-3 px-5">{{ user.email }}</td>
                            <td v-if="user" class="py-3 px-5 hidden sm:table-cell">{{ registeredSince(user) }}</td>
                            <td v-if="user" v-for="role in user.roles" class="py-3 px-5 capitalize hidden sm:table-cell">{{ role }}</td>

                        </tr>

                        </tbody>
                    </table>
                    <div
                        class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between"
                    >
              <span class="text-xs xs:text-sm text-gray-900"
              >Showing {{ meta.from }} to {{ meta.to }} of {{ meta.total }} Entries</span
              >

                        <div class="inline-flex mt-2 xs:mt-0">
                            <button @click="clickPage('prev')"
                                    class="text-sm bg-green-700 hover:bg-green-900 text-gray-50 font-semibold py-2 px-4 rounded-l"

                            >
                                Prev
                            </button>
                            <button @click="clickPage('next')"
                                    class="text-sm bg-green-700 hover:bg-green-900 text-gray-50 font-semibold py-2 px-4 rounded-r"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import axios from "axios";
import moment from "moment";
import InviteUser from "@/components/InviteUser";

import UsersLogo from "@/components/UsersLogo"


export default {
    name: "Users",
    components: {
        InviteUser,
        UsersLogo,
    },
    data() {
        return {
            link: '/api/users',
            users: {},
            links: {},
            meta: {},
        }
    },
    mounted() {
        this.fetchUsers()
    },

    methods: {

        fetchUsers() {
            axios.get(this.link)
                .then(res => {
                    this.prepareParams(res)

                }).catch(err => {
                console.log(err)
            })
        },

        prepareParams(res) {
            this.users = res.data.data
            this.links = res.data.links
            this.meta = res.data.meta
        },

        clickPage(button) {
            if (button === 'prev')
                this.link = this.links.prev

            else
                this.link = this.links.next

            this.fetchUsers();
        },


        registeredSince(user) {
            return moment(user.created_at).fromNow();
        }
    }

}
</script>
