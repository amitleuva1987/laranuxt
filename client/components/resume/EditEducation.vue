<template>
  <section>
    <form class="w-full border-b-2 border-yellow-900 pb-3 mb-3 mt-5">
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-degree-name">
            Degree Name
          </label>
          <input id="grid-company-name" v-model="education.degree_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="text" placeholder="ABC Pvt ltd">
        </div>
        <div class="w-full md:w-1/2 px-3">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-university-name">
            University Name
          </label>
          <input id="grid-university-name" v-model="education.university_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Full stack developer">
        </div>
      </div>

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-github">
            From Date
          </label>
          <input id="grid-from-date" v-model="education.from_date" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" type="date">
        </div>
        <div class="w-full md:w-1/2 px-3">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-linkedin">
            To Date
          </label>
          <input id="grid-to-date" v-model="education.to_date" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="date">
        </div>
      </div>

      <div class="w-full flex justify-center">
        <button class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-md border-4 text-white py-2 px-3 rounded" type="button" @click.once="save_education">
          SAVE
        </button>
        <button class="ml-2 bg-white text-md py-2 px-3 rounded" type="button" @click.once="show_add_experiemce_form = !show_add_experiemce_form">
          CANCEL
        </button>
      </div>
    </form>
  </section>
</template>

<script lang="ts">
import Vue from 'vue'
import { Education } from '@/types/api'
export default Vue.extend({
  name: 'EditEducation',
  props: {
    education: {
      required: true,
      type: Object as () => Education,
    },
  },

  methods: {
    async save_education ():Promise<void> {
      const data = {
        degree_name: this.education.degree_name,
        university_name: this.education.university_name,
        from_date: this.education.from_date,
        to_date: this.education.to_date,
      }

      const url = 'educations/' + this.education.id
      await this.$axios.put(url, data).then((response) => {
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Education Update Successfully',
        })
        this.$emit('refresh_education')
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
