<template>
  <section>
    <h2 class="text-xl mb-3 border-b-2 border-yellow-900 pb-3">Language</h2>
    <ul>
      <li v-for="lang in languages" :key="lang.id" class="bg-white px-3 py-2 flex justify-between mb-2">
        <span>{{ lang.language_name }}</span>
        <span><button type="button" class="text-blue-500" @click.once="edit(lang)">Edit</button> | <button type="button" class="text-red-500" @click.once="danger(lang.id)">Delete</button></span>
      </li>
    </ul>
    <add-language @refresh_language="get_languages()" />
    <edit-language v-if="enable_edit" :language="language" @refresh_language="refresh_edit()" />
  </section>
</template>
<script lang="ts">
import Vue from 'vue'
import AddLanguage from './AddLanguage.vue'
import EditLanguage from './EditLanguage.vue'
import { Language } from '@/types/api'
export default Vue.extend({
  name: 'Language',
  components: { AddLanguage, EditLanguage },
  data () {
    const languages:Language[] = []
    const enable_edit:boolean = false
    const language = {} as Language
    return {
      languages,
      enable_edit,
      language,
    }
  },
  mounted () {
    this.get_languages()
  },
  methods: {
    async refresh_edit ():Promise<void> {
      this.languages = (await this.$axios.get('languages')).data.data as Language[]
      this.enable_edit = !this.enable_edit
    },
    edit (language:Language):void {
      this.language = language
      this.enable_edit = !this.enable_edit
    },
    async get_languages (): Promise<void> {
      this.languages = (await this.$axios.get('languages')).data.data as Language[]
    },

    danger (id:number) {
      this.$modal.show({
        type: 'danger',
        title: 'Are you sure?',
        body: 'once removed, you will not be able to get it back.',
        secondary: {
          label: 'Cancel',
          theme: 'while',
          action: () => this.$toast.success('You cancelled deletion'),
        },
        primary: {
          label: 'Confirm Delete',
          theme: 'red',
          action: () => this.delete_language(id),
        },
      })
    },

    async delete_language (id:number) {
      const url = 'languages/' + id
      await this.$axios.delete(url).then(() => {
        this.get_languages()
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Language Deleted Successfully',
        })
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
