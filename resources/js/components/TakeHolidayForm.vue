<template>
    <jet-form-section>

        <template #form>


            <div class="col-span-4 sm:col-span-4">
                <jet-label for="type" value="Type of holiday" class="mb-2"/>
<!--                <jet-input class="w-full" id="type" type="text"  v-model="takeHolidayForm.type" />-->


                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="type" value="paid"  v-model="takeHolidayForm.type">
                        <span class="ml-2">Paid</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" class="form-radio" name="type" value="unpaid"  v-model="takeHolidayForm.type">
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
                <input id="start_date" type="date" :min="getMinStartDate()" v-model="takeHolidayForm.start_date"/>
                <jet-input-error :message="takeHolidayForm.errors.start_date" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-4">

                <jet-label for="end_date" value="Until"/>
                <input id="end_date" type="date" :min="getMinStartDate()" v-model="takeHolidayForm.end_date" />
                <jet-input-error :message="takeHolidayForm.errors.end_date" class="mt-2" />
            </div>


        </template>


        <template #actions>
            <jet-action-message :on="takeHolidayForm.recentlySuccessful" class="mr-3">
                Requested.
            </jet-action-message>

            <button v-on:click="requestHoliday()" :class="{ 'opacity-25': takeHolidayForm.processing }" :disabled="takeHolidayForm.processing">
                Give me a break!
            </button>
        </template>
    </jet-form-section>
</template>

<script>

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

    components: {
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
            link: '/api/roles',
            roles: [],
            takeHolidayForm: this.$inertia.form({
                type: '',
                description: '',
                start_date: '',
                end_date:'',
            })

        }
    },
    mounted() {
        this.fetchRoles()
        this.getMinStartDate()

    },

    methods: {
        requestHoliday(){

            this.takeHolidayForm.post(route('holiday.request')),{
                errorBag: 'requestHoliday',
                preserveScroll: true,
                onSuccess: () => this.takeHolidayForm.reset(),
            };

        },

        fetchRoles(){
            axios.get(this.link)
                .then(res =>{
                    console.log(res)
                    this.prepareParams(res)
                }).catch(err =>{
                console.log(err)
            })
        },

        prepareParams(res){
            this.roles = Object.values(res.data)
            console.log(this.roles)
        },
        getMinStartDate() {
            return moment().add(15,'days').format("YYYY-MM-DD");
        },

        formatDate(date){
            return moment(date).format("MMM Do YY")
        }

    },
}
</script>

