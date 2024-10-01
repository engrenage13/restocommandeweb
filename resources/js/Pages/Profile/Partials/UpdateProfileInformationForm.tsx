import PrimaryButton from '@/Components/Buttons/PrimaryButton';
import { Link, useForm, usePage } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import { FormEventHandler } from 'react';
import FormField, { IFormField } from '@/Components/Form/FormField';

export default function UpdateProfileInformation({ mustVerifyEmail, status, className = '' }: { mustVerifyEmail: boolean, status?: string, className?: string }) {
  const user = usePage().props.auth.user;
  const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
    firstname: user.firstname,
    lastname: user.lastname,
    email: user.email,
  });

  const submit: FormEventHandler = (e) => {
    e.preventDefault();

    patch(route('profile.update'));
  };

  const fields: IFormField[] = [
    {id: 'firstname', title: 'Prénom', value: data.firstname, type: 'text', autoComplete: 'firstname', isFocused: true, onChange: (e) => setData('firstname', e.target.value), required: true, errorMessage: errors.firstname},
    {id: 'lastname', title: 'Nom', value: data.lastname, type: 'text', autoComplete: 'lastname', onChange: (e) => setData('lastname', e.target.value), required: true, errorMessage: errors.lastname, className: 'mt-4'},
    {id: 'email', title: 'Adresse mail', value: data.email, type:'email', autoComplete: 'email', onChange: (e) => setData('email', e.target.value), required: true, errorMessage: errors.email, className: 'mt-4'},
  ];

  return (
    <section className={className}>
      <header>
        <h2 className="text-lg font-medium text-gray-900">Informations du profil</h2>

        <p className="mt-1 text-sm text-gray-600">
          Modifiez votre nom ou votre adresse mail.
        </p>
      </header>
      <form onSubmit={submit} className="mt-6 space-y-6">
        {fields.map(x => <FormField {...x} />)}
        {mustVerifyEmail && user.email_verified_at === null && (
          <div>
            <p className="text-sm mt-2 text-gray-800">
              Votre adresse mail n'est pas vérifié.
              <Link
                href={route('verification.send')}
                method="post"
                as="button"
                className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                Cliquez-ici pour renvoyer un mail de vérification.
              </Link>
            </p>

            {status === 'verification-link-sent' && (
              <div className="mt-2 font-medium text-sm text-green-600">
                Un nouveau mail de vérification a été envoyé à votre adresse mail.
              </div>
            )}
          </div>
        )}

        <div className="flex items-center gap-4">
          <PrimaryButton disabled={processing}>Sauvegarder</PrimaryButton>

          <Transition
            show={recentlySuccessful}
            enter="transition ease-in-out"
            enterFrom="opacity-0"
            leave="transition ease-in-out"
            leaveTo="opacity-0"
          >
            <p className="text-sm text-gray-600">Enregistré</p>
          </Transition>
        </div>
      </form>
    </section>
  );
}
