<template>
  <section>
    <form class="w-full border-b-2 border-yellow-900 pb-3 mb-3 mt-5">
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-company-name">
            Company Name
          </label>
          <input
            id="grid-company-name"
            v-model="local_experience.company_name"
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
            type="text"
            placeholder="ABC Pvt ltd"
          >
        </div>
        <div class="w-full md:w-1/2 px-3">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-job-title">
            Job Title
          </label>
          <input
            id="grid-job-title"
            v-model="local_experience.job_title"
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            type="text"
            placeholder="Full stack developer"
          >
        </div>
      </div>

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-github">
            From Date
          </label>
          <input
            id="grid-from-date"
            v-model="local_experience.from_date"
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
            type="date"
          >
        </div>
        <div class="w-full md:w-1/2 px-3">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-linkedin">
            To Date
          </label>
          <input
            id="grid-to-date"
            v-model="local_experience.to_date"
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            type="date"
          >
        </div>
      </div>

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3 mb-6 md:mb-0">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-mobile-no">
            Responsiblities
          </label>
          <textarea
            id="grid-responsibility-no"
            v-model="local_experience.responsibilities"
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            placeholder="Responsibilities"
          />
        </div>
      </div>

      <div class="w-full flex justify-center">
        <button
          class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-md border-4 text-white py-2 px-3 rounded"
          type="button"
          @click.once="save_experience"
        >
          SAVE
        </button>
        <button
          class="ml-2 bg-white text-md py-2 px-3 rounded"
          type="button"
          @click.once="show_add_experiemce_form = !show_add_experiemce_form"
        >
          CANCEL
        </button>
      </div>
    </form>
  </section>
</template>

<script lang="ts">
import Vue from 'vue'
import { Experience } from '@/types/api'
export default Vue.extend({
  name: 'EditExperience',
  props: {
    experience: {
      required: true,
      type: Object as () => Experience,
    },
  },
  data () {
    const local_experience = {} as Experience
    return {
      local_experience,
    }
  },
  mounted () {
    this.local_experience = this.experience
  },
  methods: {
    async save_experience ():Promise<void> {
      const data = {
        company_name: this.local_experience.company_name,
        job_title: this.local_experience.job_title,
        from_date: this.local_experience.from_date,
        to_date: this.local_experience.to_date,
        responsibilities: this.local_experience.responsibilities,
      }

      const url = 'experiences/' + this.local_experience.id
      await this.$axios.put(url, data).then(() => {
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Experience Update Successfully',
        })
        this.$emit('refresh_experience')
      }).catch(() => {
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
