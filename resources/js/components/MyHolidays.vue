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
                       My Holidays
                    </div>
                </div>

            </div>
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div
                    class="inline-block min-w-1/2 shadow rounded-lg overflow-hidden"
                >
                    <table class="min-w-full leading-normal">
                        <thead class="border-green-200 bg-green-200 h-12">
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2   text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                User
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Type
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Leaves on
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                            >
                                Returns on
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="holiday in holidays" :class="holidayStatusClass(holiday)">
                            <td v-if="holiday"
                                :class="holidayStatusClass(holiday)"
                                class="px-5 py-5   bg-white "
                            >
                                <div class="flex items-center">
                                    <div v-if="holiday.user.profile_photo_path === null "
                                         class="flex-shrink-0 w-10 h-10">
                                        <img
                                            class="w-full h-full rounded-full"
                                            :src="'/storage/profile-photos/default/default-avatar.png'"
                                        />
                                    </div>
                                    <div v-else class="flex-shrink-0 w-10 h-10">
                                        <img
                                            class="w-full h-full rounded-full"
                                            :src="'/storage/' + holiday.user.profile_photo_path"
                                        />
                                    </div>

                                    <div class="ml-3">
                                        <p class="whitespace-no-wrap">
                                            {{ holiday.user.name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td v-if="holiday" class="py-3 px-5 ">{{ holiday.type }}</td>
                            <td v-if="holiday" class="py-3 px-5">{{ holiday.start_date }}</td>
                            <td v-if="holiday" class="py-3 px-5">{{ holiday.end_date }}</td>

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
import JetApplicationMark from "@/Jetstream/ApplicationMark";


export default {
    name: "AllHolidays",


    components: {
        JetApplicationMark,
    },
    data() {
        return {
            link: `/holidays/${this.$page.props.user.id}`,
            holidays: {},
            links: {},
            meta: {},


        }
    },

    mounted() {
        this.fetchHolidays()
        this.getToday()

    },

    methods: {

        fetchHolidays() {
            axios.get(this.link)
                .then(res => {
                    this.prepareParams(res)
                }).catch(err => {
                console.log(err)
            })
        },


        prepareParams(res) {
            this.holidays = res.data.data
            this.links = res.data.links
            this.meta = res.data.meta
        },

        clickPage(button) {
            if (button === 'prev')
                this.link = this.links.prev

            else
                this.link = this.links.next

            this.fetchHolidays();
        },

        holidayStatusClass(holiday) {
            if ((holiday.start_date < this.getToday()) && (holiday.end_date > this.getToday()))
                return 'active-background'
            else if (holiday.end_date < this.getToday())
                return 'outdated-background'
            else
                return ''
        },

        getToday() {
            return moment().format("YYYY-MM-DD")
        }


    }

}
</script>
<style>
.active-background {
    background-color: rgb(150, 255, 50);
}

.outdated-background {
    background-color: darkgrey;
    color: grey;
}
</style>
