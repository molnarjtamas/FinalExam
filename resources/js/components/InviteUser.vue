<template>
    <jet-form-section>

        <template #form>

            <!-- Email -->
            <div class="col-span-4 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email"  v-model="inviteUserForm.email" />
                <jet-input-error :message="inviteUserForm.errors.email" class="mt-2" />
            </div>

            <div class="col-span-4 sm:col-span-4">

                <jet-input id="token" hidden="true" v-model="inviteUserForm.email" />

            </div>

        </template>

        <template #actions>
            <jet-action-message :on="inviteUserForm.recentlySuccessful" class="mr-3">
                Sent.
            </jet-action-message>

            <button v-on:click="addUser()" :class="{ 'opacity-25': inviteUserForm.processing }" :disabled="inviteUserForm.processing">
                Invite
            </button>
        </template>
    </jet-form-section>
</template>

<script>
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import Button from "@/Jetstream/Button";

export default {

    components: {
        Button,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
    },



    data() {

        return {
            inviteUserForm: this.$inertia.form({
                email: '',
                token: null,
            })

        }
    },

    methods: {
        addUser(){
            console.log(this.inviteUserForm.email)
            this.inviteUserForm.post(route('user.invite')),{
                errorBag: 'addUser',
                preserveScroll: true,
                onSuccess: () => this.inviteUserForm.reset(),
            }
        },










    },
}
</script>
