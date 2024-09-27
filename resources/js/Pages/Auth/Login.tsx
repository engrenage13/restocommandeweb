import { FormEventHandler } from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { Head, Link, useForm } from '@inertiajs/react';
import FormField, { IFormField } from '@/Components/FormField';

export default function Login({ status, canResetPassword }: { status?: string, canResetPassword: boolean }) {
  const { data, setData, post, processing, errors, reset } = useForm({
    email: '',
    password: '',
    remember: false,
  });

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    post(route('login'), {
        onFinish: () => reset('password'),
    });
  };

  const fields: IFormField[] = [
    {id: 'email', title: 'Adresse mail', value: data.email, type:'email', autoComplete: 'email', isFocused: true, onChange: (e) => setData('email', e.target.value), required: true, errorMessage: errors.email},
    {id: 'password', title: 'Mot de passe', value: data.password, type:'password', autoComplete: 'new-password', onChange: (e) => setData('password', e.target.value), required: true, errorMessage: errors.password, className:'mt-4'},
  ];

  return (
    <GuestLayout>
      <Head title="Connexion" />
      {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}
      <form onSubmit={submit}>
        {fields.map(x => <FormField {...x} />)}
        <div className="block mt-4">
          <label className="flex items-center">
            <Checkbox
              name="remember"
              checked={data.remember}
              onChange={(e) => setData('remember', e.target.checked)}
            />
            <span className="ms-2 text-sm text-gray-600">Se souvenir de moi</span>
          </label>
        </div>
        <div className="flex items-center justify-end mt-4">
          {canResetPassword && (
            <Link
              href={route('password.request')}
              className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              Mot de passe oublié ?
            </Link>
          )}
          <PrimaryButton className="ms-4" disabled={processing}>
            Me connecter
          </PrimaryButton>
        </div>
      </form>
    </GuestLayout>
  );
}
