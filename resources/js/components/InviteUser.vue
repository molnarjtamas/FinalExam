<template>
    <jet-form-section>

        <template #form>

            <!-- Email -->
            <div class="col-span-4 ">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email"  v-model="inviteUserForm.email" />
                <jet-input-error :message="inviteUserForm.errors.email" class="mt-2" />
            </div>

            <div class="col-span-4 flex-shrink-0">

                <jet-label for="role" value="Role"/>
                <v-select  id="role" class="text-xl capitalize w-56 lg:w-full " :options="roles" v-model="inviteUserForm.role"></v-select>

            </div>
            <jet-input id="token" hidden="true" v-model="inviteUserForm.email" />

        </template>


        <template #actions>
            <jet-action-message :on="inviteUserForm.recentlySuccessful" class="mr-3">
                Invitation sent.
            </jet-action-message>

            <button v-on:click="addUser()" :class="{ 'opacity-25': inviteUserForm.processing } " :disabled="inviteUserForm.processing"
                    class="text-sm bg-yellow-500 hover:bg-yellow-600 text-gray-50 font-semibold py-2 px-4 rounded">
                Invite
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
            inviteUserForm: this.$inertia.form({
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
            this.inviteUserForm.post(route('user.invite')),{
                errorBag: 'addUser',
                preserveScroll: true,
                onSuccess: () => this.inviteUserForm.reset(),
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
#role #vs1__listbox >li{
    color:black;
    background-color: white;
}
#role #vs1__listbox >li:hover{
    background-color: #047857;
    color:white;
}
</style>
