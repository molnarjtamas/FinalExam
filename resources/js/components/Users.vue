<template>

    <div class="mt-8">


        <div class="mt-6">
            <div class="flex justify-between ">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <jet-application-mark class="block h-44 w-auto"/>
                    </div>
                    <div class="self-center text-5xl ml-16 font-semibold text-gray-600 uppercase">
                        Users
                    </div>
                </div>

                <div v-can="'invite-users'">
                    <InviteUser></InviteUser>
                </div>
            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div
                    class="inline-block min-w-full shadow rounded-lg overflow-hidden"
                >
                    <table class="min-w-full leading-normal">
                        <thead class="border-green-200 bg-green-200">
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2   text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                User
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Email
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Registered
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Role
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="user in users">
                            <td v-if="user"
                                class="px-5 py-5 border-b  bg-white text-sm"
                            >
                                <div class="flex items-center">
                                    <div v-if="user.profile_photo_path === '/storage/' "
                                         class="flex-shrink-0 w-10 h-10">
                                        <img
                                            class="w-full h-full rounded-full"
                                            :src="'../storage/profile-photos/default/default-avatar.png'"
                                        />
                                    </div>
                                    <div v-else class="flex-shrink-0 w-10 h-10">
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
                            <td v-if="user" class="py-3 px-5">{{ registeredSince(user) }}</td>
                            <td v-if="user" v-for="role in user.roles" class="py-3 px-5 uppercase">{{ role }}</td>

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
                                    class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l"

                            >
                                Prev
                            </button>
                            <button @click="clickPage('next')"
                                    class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r"
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
import JetApplicationMark from "@/Jetstream/ApplicationMark";


export default {
    name: "Users",
    components: {
        InviteUser,
        JetApplicationMark,
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
