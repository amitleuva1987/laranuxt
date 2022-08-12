<template>
  <section>
    <form class="w-full mb-3" @submit.prevent="save_language">
      <div class="flex items-center">
        <Textinput
          id="name"
          :model-value.sync="local_language.language_name"
          type="text"
          label="Name"
          required="required"
          class="appearance-none block w-full text-gray-700 border border-blue-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
        />
        <button
          class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:text-md border-4 text-white py-2 px-3 rounded"
          type="submit"
        >
          SAVE
        </button>
        <button
          class="border-white bg-white border-4 text-teal-500 hover:text-teal-800 text-md py-2 px-2 rounded"
          type="button"
          @click.once="$emit('close_language')"
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
        this.$emit('close_language')
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
