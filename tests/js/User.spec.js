import { mount } from '@vue/test-utils'
import UserDetails from '@/client/components/resume/UserDetails.vue'

describe('Logo', () => {
  test('can render user details', () => {
    const wrapper = mount(UserDetails)
    expect(wrapper.text()).toContain('Personal Details')
  })
})
