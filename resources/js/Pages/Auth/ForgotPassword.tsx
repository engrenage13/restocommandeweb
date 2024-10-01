import GuestLayout from '@/Layouts/GuestLayout';
import PrimaryButton from '@/Components/Buttons/PrimaryButton';
import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import FormField, { IFormField } from '@/Components/Form/FormField';

export default function ForgotPassword({ status }: { status?: string }) {
  const { data, setData, post, processing, errors } = useForm({
    email: '',
  });

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route('password.email'));
  };

  const fields: IFormField[] = [
    {id: 'email', title: 'Adresse mail', value: data.email, type:'email', autoComplete: 'email', isFocused: true, onChange: (e) => setData('email', e.target.value), required: true, errorMessage: errors.email},
  ];

  return (
    <GuestLayout>
      <Head title="Mot de passe oublié" />
      <div className="mb-4 text-sm text-gray-600">
        Vous avez oublié votre mot de passe ? Pas de problème. Renseignez votre adresse mail dans le champs ci-dessous et 
        nous vous envaierons un mail comportant un lien permettant de réinitialiser votre mot de passe et d'en saisir un nouveau.
      </div>
      {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}
      <form onSubmit={submit}>
        {fields.map(x => <FormField {...x} />)}
        <div className="flex items-center justify-end mt-4">
          <PrimaryButton className="ms-4" disabled={processing}>
            Envoyer un mail
          </PrimaryButton>
        </div>
      </form>
    </GuestLayout>
  );
}
