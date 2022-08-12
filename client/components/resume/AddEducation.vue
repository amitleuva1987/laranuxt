<template>
  <section>
    <div v-if="!show_add_educatoin_form" class="w-full flex justify-center mb-3 border-b-2 border-gray-200 pb-3">
      <button class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-md border-4 text-white py-2 px-3 rounded mt-3" type="button" @click="show_add_educatoin_form = !show_add_educatoin_form">
        ADD EDUCATION
      </button>
    </div>

    <form v-if="show_add_educatoin_form" class="w-full border-b-2 border-gray-200 pb-3 mb-3" @submit.prevent="save_education">
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-degree-name">
            Degree Name
          </label>
          <Textinput
            id="name"
            :model-value.sync="education.degree_name"
            type="text"
            label="Name"
            required="required"
            placeholder="BE"
            class="appearance-none block w-full text-gray-700 border border-blue-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          />
        </div>
        <div class="w-full md:w-1/2 px-3">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-university-name">
            University Name
          </label>
          <Textinput
            id="name"
            :model-value.sync="education.university_name"
            type="text"
            label="Name"
            required="required"
            placeholder="Gujarat University"
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
            :model-value.sync="education.from_date"
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
            :model-value.sync="education.to_date"
            type="date"
            label="Name"
            required="required"
            class="appearance-none block w-full text-gray-700 border border-blue-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
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
          @click.once="show_add_educatoin_form = !show_add_educatoin_form"
        >
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
  name: 'AddEducation',
  data () {
    const show_add_educatoin_form:boolean = false
    const education = {} as Education

    return {
      show_add_educatoin_form,
      education,
    }
  },
  methods: {
    async save_education ():Promise<void> {
      const data = {
        degree_name: this.education.degree_name,
        university_name: this.education.university_name,
        from_date: this.education.from_date,
        to_date: this.education.to_date,
      }
      console.log(data)
      await this.$axios.post('educations', data).then(() => {
        this.show_add_educatoin_form = !this.show_add_educatoin_form
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Education Added Successfully',
        })
        this.$emit('refresh_education')
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
