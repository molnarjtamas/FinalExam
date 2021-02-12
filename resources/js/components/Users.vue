<template>
    <!--    <div>-->
    <!--        <h3 class="text-gray-700 text-3xl font-medium">Users</h3>-->

    <!--        <div class="mt-4">-->
    <!--            <h4 class="text-gray-600">Registered users</h4>-->

    <!--            <div class="mt-6">-->
    <!--                <div class="bg-white shadow rounded-md overflow-hidden my-6">-->
    <!--                    <table class="text-left w-full border-collapse">-->
    <!--                        <thead class="border-b">-->
    <!--                        <tr>-->
    <!--                            <th-->
    <!--                                class="py-3 px-5 bg-green-800 font-medium uppercase text-sm text-gray-100"-->
    <!--                            >-->
    <!--                                Name-->
    <!--                            </th>-->
    <!--                            <th-->
    <!--                                class="py-3 px-5 bg-green-800 font-medium uppercase text-sm text-gray-100"-->
    <!--                            >-->
    <!--                                Email-->
    <!--                            </th>-->

    <!--                        </tr>-->
    <!--                        </thead>-->
    <!--                        <tbody>-->

    <!--                        <tr v-for="user in this.users">-->

    <!--                            <td class="py-4 px-5">{{user.name}}</td>-->
    <!--                            <td class="py-3 px-5">{{user.email}}</td>-->

    <!--                        </tr>-->
    <!--                        </tbody>-->
    <!--                    </table>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <div class="mt-8">


        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-700 leading-tight">Users</h2>

            <!--            <div class="mt-3 flex flex-col sm:flex-row">-->
            <!--                <div class="flex">-->
            <!--                    <div class="relative">-->
            <!--                        <select-->
            <!--                            class="appearance-none h-full rounded-l border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"-->
            <!--                        >-->
            <!--                            <option>5</option>-->
            <!--                            <option>10</option>-->
            <!--                            <option>20</option>-->
            <!--                        </select>-->

            <!--                        <div-->
            <!--                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"-->
            <!--                        >-->

            <!--                        </div>-->
            <!--                    </div>-->

            <!--                    <div class="relative">-->
            <!--                        <select-->
            <!--                            class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500"-->
            <!--                        >-->
            <!--                            <option>All</option>-->
            <!--                            <option>Active</option>-->
            <!--                            <option>Inactive</option>-->
            <!--                        </select>-->

            <!--                        <div-->
            <!--                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"-->
            <!--                        >-->

            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->

            <!--                <div class="block relative mt-2 sm:mt-0">-->
            <!--            <span class="absolute inset-y-0 left-0 flex items-center pl-2">-->
            <!--              <svg-->
            <!--                  viewBox="0 0 24 24"-->
            <!--                  class="h-4 w-4 fill-current text-gray-500"-->
            <!--              >-->
            <!--                <path-->
            <!--                    d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z"-->
            <!--                />-->
            <!--              </svg>-->
            <!--            </span>-->

            <!--                    <input-->
            <!--                        placeholder="Search"-->
            <!--                        class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none"-->
            <!--                    />-->
            <!--                </div>-->
            <!--            </div>-->

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
                                Status
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <!--                        <tr v-for="(u, index) in paginatedTableData" :key="index">-->
                        <!--                            <td-->
                        <!--                                class="px-5 py-5 border-b  bg-white text-sm"-->
                        <!--                            >-->
                        <!--                                <div class="flex items-center">-->
                        <!--                                    <div class="flex-shrink-0 w-10 h-10">-->
                        <!--                                        <img-->
                        <!--                                            class="w-full h-full rounded-full"-->
                        <!--                                            :src="u.picture"-->
                        <!--                                            alt-->
                        <!--                                        />-->
                        <!--                                    </div>-->

                        <!--                                    <div class="ml-3">-->
                        <!--                                        <p class="text-gray-900 whitespace-no-wrap">-->
                        <!--                                            {{ u.name }}-->
                        <!--                                        </p>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </td>-->
                        <!--                            <td-->
                        <!--                                class="px-5 py-5 border-b  bg-white text-sm"-->
                        <!--                            >-->
                        <!--                                <p class="text-gray-900 whitespace-no-wrap">{{ u.role }}</p>-->
                        <!--                            </td>-->
                        <!--                            <td-->
                        <!--                                class="px-5 py-5 border-b  bg-white text-sm"-->
                        <!--                            >-->
                        <!--                                <p class="text-gray-900 whitespace-no-wrap">-->
                        <!--                                    {{ u.created }}-->
                        <!--                                </p>-->
                        <!--                            </td>-->
                        <!--                            <td-->
                        <!--                                class="px-5 py-5 border-b  bg-white text-sm"-->
                        <!--                            >-->
                        <!--                    <span-->
                        <!--                        :class="`relative inline-block px-3 py-1 font-semibold text-${u.statusColor}-900 leading-tight`"-->
                        <!--                    >-->
                        <!--                      <span-->
                        <!--                          aria-hidden-->
                        <!--                          :class="`absolute inset-0 bg-${u.statusColor}-200 opacity-50 rounded-full`"-->
                        <!--                      ></span>-->
                        <!--                      <span class="relative">{{ u.status }}</span>-->
                        <!--                    </span>-->
                        <!--                            </td>-->
                        <!--                        </tr>-->

                        <tr v-for="user in this.users">

                            <td class="py-4 px-5">{{user.name}}</td>
                            <td class="py-3 px-5">{{user.email}}</td>
                            <td class="py-3 px-5">{{registeredSince(user)}}</td>

                        </tr>

                        </tbody>
                    </table>
                    <div
                        class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between"
                    >
              <span class="text-xs xs:text-sm text-gray-900"
              >Showing {{this.meta.from}} to {{ this.meta.to }} of {{ this.meta.total}} Entries</span
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

export default {
    name: "Users",
    data() {
        return {
            link: 'http://127.0.0.1:8000/api/users',
            users: null,
            links: null,
            meta: null,
            isActive: true

        }
    },
    mounted() {
        this.fetchUsers()
        this.registeredSince(user)
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

        setButtonStatus() {
            if ((this.links.prev == null) || (this.links.next == null))
                this.isActive = false
        },


        registeredSince(user) {
            return moment(user.created_at).fromNow();
        }
    }

}
</script>
