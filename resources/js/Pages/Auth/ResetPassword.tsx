import { FormEventHandler } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/Form/InputError';
import InputLabel from '@/Components/Form/InputLabel';
import PrimaryButton from '@/Components/Buttons/PrimaryButton';
import TextInput from '@/Components/Form/TextInput';
import { Head, useForm } from '@inertiajs/react';
import FormField, { IFormField } from '@/Components/Form/FormField';

export default function ResetPassword({ token, email }: { token: string, email: string }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    token: token,
    email: email,
    password: '',
    password_confirmation: '',
  });

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route('password.store'), {
        onFinish: () => reset('password', 'password_confirmation'),
    });
  };

  const fields: IFormField[] = [
    {id: 'email', title: 'Adresse mail', value: data.email, type: 'email', autoComplete: 'email', isFocused: true, onChange: (e) => setData('email', e.target.value), required: true, errorMessage: errors.email},
    {id: 'password', title: 'Mot de passe', value: data.password, type: 'password', autoComplete: 'new-password', onChange: (e) => setData('password', e.target.value), required: true, errorMessage: errors.password, className: 'mt-4'},
    {id: 'password_confirmation', title: 'Confirmer le mot de passe', value: data.password_confirmation, type: 'password', autoComplete: 'new-password', onChange: (e) => setData('password_confirmation', e.target.value), required: true, errorMessage: errors.password_confirmation, className: 'mt-4'}
  ];

  return (
    <GuestLayout>
      <Head title="Réinitialiser le mot de passe" />
      <form onSubmit={submit}>
        {fields.map(x => <FormField {...x} />)}
        <div className="flex items-center justify-end mt-4">
          <PrimaryButton className="ms-4" disabled={processing}>
            Réinitialiser le mot de passe
          </PrimaryButton>
        </div>
      </form>
    </GuestLayout>
  );
}
