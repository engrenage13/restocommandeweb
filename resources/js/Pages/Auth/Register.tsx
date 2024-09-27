import { FormEventHandler } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { Head, Link, useForm } from '@inertiajs/react';
import FormField, { IFormField } from '@/Components/FormField';

export default function Register() {
  const { data, setData, post, processing, errors, reset } = useForm({
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
  });

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route('register'), {
      onFinish: () => reset('password', 'password_confirmation'),
    });
  };

  const fields: IFormField[] = [
    {id: 'lastname', title: 'Nom', value: data.lastname, type:'text', autoComplete: 'lastname', isFocused: true, onChange: (e) => setData('lastname', e.target.value), required: true, errorMessage: errors.lastname},
    {id: 'firstname', title: 'Prénom', value: data.firstname, type:'text', autoComplete: 'firstname', onChange: (e) => setData('firstname', e.target.value), required: true, errorMessage: errors.firstname, className:'mt-4'},
    {id: 'email', title: 'Adresse mail', value: data.email, type:'email', autoComplete: 'email', onChange: (e) => setData('email', e.target.value), required: true, errorMessage: errors.email, className:'mt-4'},
    {id: 'password', title: 'Mot de passe', value: data.password, type:'password', autoComplete: 'new-password', onChange: (e) => setData('password', e.target.value), required: true, errorMessage: errors.password, className:'mt-4'},
    {id: 'password_confirmation', title: 'Confirmation du mot de passe', value: data.password_confirmation, type:'password', autoComplete: 'new-password', onChange: (e) => setData('password_confirmation', e.target.value), required: true, errorMessage: errors.password_confirmation, className:'mt-4'},
  ];

  return (
    <GuestLayout>
      <Head title="Créer mon compte" />
      <form onSubmit={submit}>
        {fields.map(x => <FormField {...x} />)}
        <div className="flex items-center justify-end mt-4">
          <Link
            href={route('login')}
            className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            J'ai déjà un compte. Me connecter
          </Link>

          <PrimaryButton className="ms-4" disabled={processing}>
            Créer mon compte
          </PrimaryButton>
        </div>
      </form>
    </GuestLayout>
  );
}
