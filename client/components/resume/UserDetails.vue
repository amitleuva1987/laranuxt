<template>
  <form class="w-full border-b-2 border-yellow-900 pb-3 mb-3">
    <h2 class="text-xl mb-3 border-b-2 border-yellow-900 pb-3">Personal Details</h2>
    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
          Name
        </label>
        <input id="grid-first-name" v-model="user.name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="Jane">
        <p class="text-red-500 text-xs italic">Please fill out this field.</p>
      </div>
      <div class="w-full md:w-1/2 px-3">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-job-title">
          Job Title
        </label>
        <input id="grid-job-title" v-model="user.job_title" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Full stack developer">
      </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-github">
          Github Profile
        </label>
        <input id="grid-github" v-model="user.github_profile" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="Jane">
        <p class="text-red-500 text-xs italic">Please fill out this field.</p>
      </div>
      <div class="w-full md:w-1/2 px-3">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-linkedin">
          Linkedin Profile
        </label>
        <input id="grid-linkedin" v-model="user.linkedin_profile" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="https://linkedin.com/profile">
      </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-mobile-no">
          Mobile Number
        </label>
        <input id="grid-mobile-no" v-model="user.mobile_no" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="+1 123 234">
      </div>
      <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-email">
          Email
        </label>
        <input id="grid-email" v-model="user.email" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="myname@example.com">
      </div>
      <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-location">
          Location
        </label>
        <input id="grid-location" v-model="user.location" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="city, country">
      </div>
    </div>

    <div class="flex flex-wrap -mx-3 mb-6">
      <div class="w-full px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-mobile-no">
          Description
        </label>
        <textarea id="grid-responsibility-no" v-model="user.description" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Description" />
      </div>
    </div>

    <div class="w-full flex justify-center">
      <button class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-md border-4 text-white py-2 px-3 rounded" type="button" @click.once="update_user">
        SAVE
      </button>
    </div>
  </form>
</template>

<script lang="ts">
import Vue from 'vue'
import { User } from '@/types/api'
export default Vue.extend({
  name: 'UserDetails',
  data () {
    const user = {} as User
    return {
      user,
    }
  },
  mounted () {
    this.get_user()
  },
  methods: {
    async get_user ():Promise<void> {
      this.user = (
            await this.$axios.get('users/1')
        ).data.data as User
    },

    async update_user ():Promise<void> {
      const data = {
        name: this.user.name,
        email: this.user.email,
        job_title: this.user.job_title,
        mobile_no: this.user.mobile_no,
        github_profile: this.user.github_profile,
        linkedin_profile: this.user.linkedin_profile,
        location: this.user.location,
        description: this.user.description,
      }
      this.$axios.put('users/1', data).then((response) => {
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Profile Updated Successfully',
        })
        this.get_user()
      }).catch((error) => {
        this.$toast.show({
          type: 'danger',
          title: 'Error',
          message: 'Oops, something went wrong',
        })
      })
    },
  },
})
</script>
