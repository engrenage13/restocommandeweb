import { FormEventHandler } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { Head, useForm } from '@inertiajs/react';
import FormField, { IFormField } from '@/Components/FormField';

export default function ConfirmPassword() {
  const { data, setData, post, processing, errors, reset } = useForm({
    password: '',
  });

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route('password.confirm'), {
      onFinish: () => reset('password'),
    });
  };

  const fields: IFormField[] = [
    {id: 'password', title: 'Mot de passe', value: data.password, type:'password', autoComplete: 'password', isFocused: true, onChange: (e) => setData('password', e.target.value), required: true, errorMessage: errors.password},
  ];

  return (
    <GuestLayout>
      <Head title="Confirmation du mot de passe" />
      <div className="mb-4 text-sm text-gray-600">
        Vous accédez à une zone sécurisée de l'application. Merci de confirmer votre mot de passe avant de continuer.
      </div>
      <form onSubmit={submit}>
        {fields.map(x => <FormField {...x} />)}
        <div className="flex items-center justify-end mt-4">
          <PrimaryButton className="ms-4" disabled={processing}>
            Confirmer le mot de passe
          </PrimaryButton>
        </div>
      </form>
    </GuestLayout>
  );
}
