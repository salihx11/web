import { useState } from 'react'
import { supabase } from '../../lib/supabase'
import { useRouter } from 'next/router'

export default function Login() {
    const [email, setEmail] = useState('')
    const [password, setPassword] = useState('')
    const [loading, setLoading] = useState(false)
    const [error, setError] = useState('')
    const router = useRouter()

    const handleLogin = async(e) => {
        e.preventDefault()
        setLoading(true)
        setError('')

        try {
            // Sign in with Supabase
            const { data, error } = await supabase.auth.signInWithPassword({
                email,
                password,
            })

            if (error) throw error

            // Check if user is admin
            const { data: admin, error: adminError } = await supabase
                .from('admins')
                .select('*')
                .eq('user_id', data.user.id)
                .single()

            if (adminError || !admin) {
                await supabase.auth.signOut()
                throw new Error('Not authorized as admin')
            }

            // Redirect to admin dashboard
            router.push('/admin/dashboard')
        } catch (error) {
            setError(error.message)
        } finally {
            setLoading(false)
        }
    }

    return ( <
        div style = {
            {
                minHeight: '100vh',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                backgroundColor: '#f5f5f5'
            }
        } >
        <
        div style = {
            {
                backgroundColor: 'white',
                padding: '2rem',
                borderRadius: '8px',
                boxShadow: '0 2px 10px rgba(0,0,0,0.1)',
                width: '100%',
                maxWidth: '400px'
            }
        } >
        <
        h2 style = {
            { textAlign: 'center', marginBottom: '2rem' } } >
        CoinSpark Admin Login <
        /h2>

        <
        form onSubmit = { handleLogin } > {
            error && ( <
                div style = {
                    {
                        backgroundColor: '#fee2e2',
                        border: '1px solid #fecaca',
                        color: '#dc2626',
                        padding: '0.75rem',
                        borderRadius: '4px',
                        marginBottom: '1rem'
                    }
                } > { error } <
                /div>
            )
        }

        <
        div style = {
            { marginBottom: '1rem' } } >
        <
        label style = {
            { display: 'block', marginBottom: '0.5rem', fontWeight: '500' } } >
        Email <
        /label> <
        input type = "email"
        required value = { email }
        onChange = {
            (e) => setEmail(e.target.value) }
        style = {
            {
                width: '100%',
                padding: '0.5rem',
                border: '1px solid #d1d5db',
                borderRadius: '4px',
                fontSize: '1rem'
            }
        }
        placeholder = "Enter your email" /
        >
        <
        /div>

        <
        div style = {
            { marginBottom: '1.5rem' } } >
        <
        label style = {
            { display: 'block', marginBottom: '0.5rem', fontWeight: '500' } } >
        Password <
        /label> <
        input type = "password"
        required value = { password }
        onChange = {
            (e) => setPassword(e.target.value) }
        style = {
            {
                width: '100%',
                padding: '0.5rem',
                border: '1px solid #d1d5db',
                borderRadius: '4px',
                fontSize: '1rem'
            }
        }
        placeholder = "Enter your password" /
        >
        <
        /div>

        <
        button type = "submit"
        disabled = { loading }
        style = {
            {
                width: '100%',
                backgroundColor: loading ? '#9ca3af' : '#3b82f6',
                color: 'white',
                padding: '0.75rem',
                border: 'none',
                borderRadius: '4px',
                fontSize: '1rem',
                cursor: loading ? 'not-allowed' : 'pointer'
            }
        } >
        { loading ? 'Signing in...' : 'Sign in' } <
        /button> <
        /form> <
        /div> <
        /div>
    )
}
