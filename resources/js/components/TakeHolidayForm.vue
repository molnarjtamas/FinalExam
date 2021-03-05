<template>
    <jet-form-section>

        <template #form>


            <div class="col-span-4 sm:col-span-4">
                <jet-label for="type" value="Type of holiday" />
                <jet-input id="type" type="text"  v-model="takeHolidayForm.type" />
                <jet-input-error :message="takeHolidayForm.errors.type" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-4">
                <jet-label for="description" value="Description" />
                <textarea  class="h-24 custom-width resize-none border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" id="description"    />

            </div>

            <div class="col-span-4 sm:col-span-4">

                <jet-label for="startdate" value="Starting on"/>
                <jet-input id="startdate" type="date"/>
                <jet-input-error :message="takeHolidayForm.errors.startdate" class="mt-2" />
            </div>
            <div class="col-span-4 sm:col-span-4">

                <jet-label for="enddate" value="Until"/>
                <jet-input id="enddate" type="date"/>
                <jet-input-error :message="takeHolidayForm.errors.enddate" class="mt-2" />
            </div>


        </template>


        <template #actions>
            <jet-action-message :on="takeHolidayForm.recentlySuccessful" class="mr-3">
                Sent.
            </jet-action-message>

            <button v-on:click="addUser()" :class="{ 'opacity-25': takeHolidayForm.processing }" :disabled="takeHolidayForm.processing">
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

export default {

    components: {
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
            link: 'http://127.0.0.1:8000/api/roles',
            roles: [],
            takeHolidayForm: this.$inertia.form({
                email: '',
                token: null,
                role: null,
            })

        }
    },
    mounted() {
        this.fetchRoles()
    },

    methods: {
        addUser(){
            this.takeHolidayForm.post(route('user.invite')),{
                errorBag: 'addUser',
                preserveScroll: true,
                onSuccess: () => this.takeHolidayForm.reset(),
            }
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
        }

    },
}
</script>

<style>
.custom-width{
    width: 95%;
}
</style>
