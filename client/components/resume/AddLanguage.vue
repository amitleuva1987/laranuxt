<template>
  <section>
    <div v-if="!show_add_language_form" class="w-full flex justify-center mb-3 border-b-2 border-yellow-900 pb-3">
      <button class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-md border-4 text-white py-2 px-3 rounded mt-3" type="button" @click="show_add_language_form = !show_add_language_form">
        ADD LANGUAGE
      </button>
    </div>

    <form v-if="show_add_language_form" class="w-full border-b-2 border-yellow-900 pb-3 mb-3">
      <div class="flex items-center border-b border-teal-500 py-2">
        <input v-model="language.language_name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Language Name" aria-label="Full name">
        <button class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:text-md border-4 text-white py-2 px-3 rounded" type="button" @click.once="save_language">
          SAVE
        </button>
        <button class="border-white bg-white border-4 text-teal-500 hover:text-teal-800 text-md py-2 px-2 rounded" type="button" @click.once="show_add_language_form = !show_add_language_form">
          Cancel
        </button>
      </div>
    </form>
  </section>
</template>

<script lang="ts">
import Vue from 'vue'
import { Language } from '@/types/api'
export default Vue.extend({
  name: 'AddLanguage',
  data () {
    const show_add_language_form:boolean = false
    const language = {} as Language

    return {
      show_add_language_form,
      language,
    }
  },
  methods: {
    async save_language ():Promise<void> {
      const data = {
        language_name: this.language.language_name,
      }

      await this.$axios.post('languages', data).then((response) => {
        this.show_add_language_form = !this.show_add_language_form
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Language Added Successfully',
        })
        this.$emit('refresh_language')
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
