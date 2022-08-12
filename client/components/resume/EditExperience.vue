<template>
  <section>
    <form class="w-full border-b-2 border-gray-200 pb-3 mb-3 mt-5" @submit.prevent="save_experience">
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-company-name">
            Company Name
          </label>
          <Textinput
            id="name"
            :model-value.sync="local_experience.company_name"
            type="text"
            label="Name"
            required="required"
            class="appearance-none block w-full text-gray-700 border border-blue-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          />
        </div>
        <div class="w-full md:w-1/2 px-3">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-job-title">
            Job Title
          </label>
          <Textinput
            id="name"
            :model-value.sync="local_experience.job_title"
            type="text"
            label="Name"
            required="required"
            class="appearance-none block w-full text-gray-700 border border-blue-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          />
        </div>
      </div>

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-github">
            From Date
          </label>
          <Textinput
            id="name"
            :model-value.sync="local_experience.from_date"
            type="date"
            label="Name"
            required="required"
            class="appearance-none block w-full text-gray-700 border border-blue-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          />
        </div>
        <div class="w-full md:w-1/2 px-3">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-linkedin">
            To Date
          </label>
          <Textinput
            id="name"
            :model-value.sync="local_experience.to_date"
            type="date"
            label="Name"
            required="required"
            class="appearance-none block w-full text-gray-700 border border-blue-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          />
        </div>
      </div>

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3 mb-6 md:mb-0">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-mobile-no">
            Responsiblities
          </label>
          <textarea-input
            id="description"
            :model-value.sync="local_experience.responsibilities"
            type="tel"
            required="required"
            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            label="Description"
          />
        </div>
      </div>

      <div class="w-full flex justify-center">
        <button
          class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-md border-4 text-white py-2 px-3 rounded"
          type="submit"
        >
          SAVE
        </button>
        <button
          class="ml-2 bg-white text-md py-2 px-3 rounded"
          type="button"
          @click="$emit('close_experience')"
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
        this.$emit('close_experience')
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
