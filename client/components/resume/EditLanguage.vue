<template>
  <section>
    <form class="w-full border-b-2 border-yellow-900 pb-3 mb-3 mt-5">
      <div class="flex items-center border-b border-teal-500 py-2">
        <input
          v-model="local_language.language_name"
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          type="text"
          placeholder="Language Name"
          aria-label="Full name"
        >
        <button
          class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:text-md border-4 text-white py-2 px-3 rounded"
          type="button"
          @click.once="save_language"
        >
          SAVE
        </button>
        <button
          class="border-white bg-white border-4 text-teal-500 hover:text-teal-800 text-md py-2 px-2 rounded"
          type="button"
          @click.once="show_add_language_form = !show_add_language_form"
        >
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
  name: 'EditLanguage',
  props: {
    language: {
      required: true,
      type: Object as () => Language,
    },
  },
  data () {
    const local_language = {} as Language
    return {
      local_language,
    }
  },
  mounted () {
    this.local_language = this.language
  },
  methods: {
    async save_language ():Promise<void> {
      const data = {
        language_name: this.local_language.language_name,
      }

      const url = 'languages/' + this.local_language.id
      await this.$axios.put(url, data).then(() => {
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Language Update Successfully',
        })
        this.$emit('refresh_language')
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
