

<template>
<div class="lg:flex">
    <div class="mt-8">


        <div class="mt-6">
            <div class="lg:flex justify-between ">
                <div class="lg:flex pl-6">
                    <!-- Logo -->
                    <div class="flex  items-center">
                        <HolidayMark class="self-center block h-44 w-full"/>
                    </div>
                    <div class="self-center text-5xl ml-8 sm:ml-16 font-semibold text-gray-600 uppercase">
                        My holidays
                    </div>
                </div>

            </div>
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div >
                        <p class="font-bold">Everyone has 21 paid vacation days by default</p>
                        <p v-if="holidays[0]" class="text-sm">You have left : {{holidays[0].user.days_left}} </p>
                        <p v-else class="text-sm">You have left: 21</p>
                        <p class="text-sm">Note that paid requests longer than that will be automatically rejected.</p>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-8 py-4 overflow-x-auto">
                <div
                    class="inline-block  shadow rounded-lg overflow-hidden"
                >
                    <table class="min-w-full leading-normal">
                        <thead class="border-green-800 bg-green-800 text-white  text-left text-xs sm:text-sm font-semibold uppercase tracking-wider">
                        <tr>

                            <th
                                class="px-5 py-3 border-b-2 hidden sm:table-cell "
                            >
                                Type
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 hidden sm:table-cell"
                            >
                                Description
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   "
                            >
                                I leave on
                            </th>
                            <th
                                class="px-5 py-3 border-b-2  "
                            >
                                Until
                            </th>
                            <th
                                class="px-5 py-3 border-b-2   "
                            >
                                Status
                            </th>

                        </tr>
                        </thead>
                        <tbody class="text-xs sm:text-lg">

                        <tr v-for="holiday in holidays" :class="holidayStatusClass(holiday)">

                            <td v-if="holiday" class="py-3 px-5 hidden sm:table-cell">{{ holiday.type }}</td>
                            <td v-if="holiday" class="py-3 px-5 hidden sm:table-cell">{{ holiday.description }}</td>
                            <td v-if="holiday" class="py-3 px-5">{{ formatDate(holiday.start_date )}}</td>
                            <td v-if="holiday" class="py-3 px-5">{{formatDate(holiday.end_date )}}</td>
                            <td v-if="holiday" class="py-3 px-5">
                                <div v-if="holiday.approved">
                                    <CheckMark class="h-8 w-8 ml-2 text-green-700"></CheckMark>

                                </div>
                                <div v-else>
                                    <Waiting class="h-8 w-8 ml-2"></Waiting>
                                </div>
                            </td>


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
    <div class="flex justify-start self-end mb-6 mx-8">

        <jet-form-section>

            <template #form>


                <div class="col-span-4 sm:col-span-4">
                    <jet-label for="type" value="Type of holiday" class="mb-2"/>
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="type" value="paid" :disabled="runOutOfPaid" v-model="takeHolidayForm.type">
                        <span class="ml-2">Paid</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" class="form-radio" name="type" value="unpaid"   v-model="takeHolidayForm.type">
                        <span class="ml-2">Unpaid</span>
                    </label>

                    <jet-input-error :message="takeHolidayForm.errors.type" class="mt-2" />
                </div>
                <div class="col-span-4 sm:col-span-4">
                    <jet-label for="description" value="Description" />
                    <textarea  class="h-24 w-full resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                               id="description" v-model="takeHolidayForm.description"/>
                    <jet-input-error :message="takeHolidayForm.errors.description" class="mt-2" />


                </div>

                <div class="col-span-4 sm:col-span-4">

                    <jet-label for="start_date" value="Starting on"/>
                    <input class="border-gray-300 focus:border-green-700 focus:ring focus:ring-green-600 focus:ring-opacity-50 rounded-md shadow-sm" id="start_date" type="date" :min="getMinStartDate()" v-model="takeHolidayForm.start_date"/>
                    <jet-input-error :message="takeHolidayForm.errors.start_date" class="mt-2" />
                </div>
                <div class="col-span-4 sm:col-span-4">

                    <jet-label for="end_date" value="Until"/>
                    <input class="border-gray-300 focus:border-green-700 focus:ring focus:ring-green-600 focus:ring-opacity-50 rounded-md shadow-sm" id="end_date" type="date" :min="getMinStartDate()" v-model="takeHolidayForm.end_date" />
                    <jet-input-error :message="takeHolidayForm.errors.end_date" class="mt-2" />
                </div>


            </template>


            <template #actions>
                <jet-action-message :on="takeHolidayForm.recentlySuccessful" class="mr-3">
                    {{getMessage}}
                </jet-action-message>

                <button  class="text-sm bg-yellow-500 hover:bg-yellow-600 text-gray-50 font-semibold py-2 px-4 rounded" v-on:click="requestHoliday()" :class="{ 'opacity-25': takeHolidayForm.processing }" :disabled="takeHolidayForm.processing">
                    Give me a break!
                </button>
            </template>
        </jet-form-section>

    </div>

</div>
</template>

<script>

import axios from "axios";
import HolidayMark from "@/components/HolidayMark"
import CheckMark from "@/components/CheckMark"
import Waiting from "@/components/Waiting"
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import 'vue-select/dist/vue-select.css';
import Button from "@/Jetstream/Button";
import vSelect from 'vue-select'
import ValidationErrors from "@/Jetstream/ValidationErrors";
import moment from "moment";

export default {
    name: "MyHolidays",

    props:['success','message'],
    components: {
        HolidayMark,
        CheckMark,
        Waiting,
        ValidationErrors,
        Button,
        JetActionMessage,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        vSelect,
    },
    data() {
        return {
            link: `/holidays/${this.$page.props.user.id}`,
            holidays: {},
            links: {},
            meta: {},
            takeHolidayForm: this.$inertia.form({
                type: '',
                description: '',
                start_date: '',
                end_date:'',
            }),
        }
    },

    computed: {
        runOutOfPaid: function () {
            return (this.holidays) && (this.holidays[0]?.user.days_left < 1);
        },
        getResult: function () {
            return this.success;
        },
        getMessage: function () {
            return this.message;
        },
    },
    mounted() {
        this.fetchHolidays()
        this.getToday()
        this.getMinStartDate()
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

        requestHoliday(){

            this.takeHolidayForm.post(route('holiday.request'),{
                errorBag: 'requestHoliday',
                preserveScroll: true,
                onSuccess: () => {
                    this.takeHolidayForm.reset();
                    this.fetchHolidays();

                }

            });

        },
        getMinStartDate() {
            return moment().add(15,'days').format("YYYY-MM-DD");
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
        },
        formatDate(date){
            return moment(date).format("MMM Do, YY")
        },

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
