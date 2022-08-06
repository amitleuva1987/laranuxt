<template>
  <section>
    <form class="w-full border-b-2 border-yellow-900 pb-3 mb-3 mt-5" @submit.prevent="save_hobby">
      <div class="flex items-center border-b border-teal-500 py-2">
        <input
          v-model="local_hobby.hobby_name"
          class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          type="text"
          placeholder="Hobby Name"
          aria-label="Full name"
          required="required"
        >
        <button
          class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:text-md border-4 text-white py-2 px-3 rounded"
          type="submit"
        >
          SAVE
        </button>
        <button
          class="border-white bg-white border-4 text-teal-500 hover:text-teal-800 text-md py-2 px-2 rounded"
          type="button"
          @click.once="show_add_hobby_form = !show_add_hobby_form"
        >
          Cancel
        </button>
      </div>
    </form>
  </section>
</template>

<script lang="ts">
import Vue from 'vue'
import { Hobby } from '@/types/api'
export default Vue.extend({
  name: 'EditHobby',
  props: {
    hobby: {
      required: true,
      type: Object as () => Hobby,
    },
  },
  data () {
    const local_hobby = {} as Hobby
    return {
      local_hobby,
    }
  },
  mounted () {
    this.local_hobby = this.hobby
  },
  methods: {
    async save_hobby ():Promise<void> {
      const data = {
        hobby_name: this.local_hobby.hobby_name,
      }

      const url = 'hobbies/' + this.local_hobby.id
      await this.$axios.put(url, data).then(() => {
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Hobby Update Successfully',
        })
        this.$emit('refresh_hobby')
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
