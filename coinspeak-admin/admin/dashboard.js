import { useEffect, useState } from 'react'
import { supabase } from '../../lib/supabase'
import { useRouter } from 'next/router'

export default function Dashboard() {
    const [user, setUser] = useState(null)
    const [loading, setLoading] = useState(true)
    const router = useRouter()

    useEffect(() => {
        checkAuth()
    }, [])

    const checkAuth = async() => {
        try {
            const { data: { session } } = await supabase.auth.getSession()

            if (!session) {
                router.push('/auth/login')
                return
            }

            // Verify user is admin
            const { data: admin } = await supabase
                .from('admins')
                .select('*')
                .eq('user_id', session.user.id)
                .single()

            if (!admin) {
                await supabase.auth.signOut()
                router.push('/auth/login')
                return
            }

            setUser(session.user)
        } catch (error) {
            console.error('Auth error:', error)
            router.push('/auth/login')
        } finally {
            setLoading(false)
        }
    }

    const handleLogout = async() => {
        await supabase.auth.signOut()
        router.push('/auth/login')
    }

    if (loading) {
        return ( <
            div style = {
                {
                    minHeight: '100vh',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center'
                }
            } >
            <
            div > Loading... < /div> <
            /div>
        )
    }

    return ( <
        div style = {
            { padding: '2rem' } } >
        <
        div style = {
            {
                display: 'flex',
                justifyContent: 'space-between',
                alignItems: 'center',
                marginBottom: '2rem',
                borderBottom: '1px solid #e5e7eb',
                paddingBottom: '1rem'
            }
        } >
        <
        h1 style = {
            { fontSize: '1.5rem', fontWeight: 'bold' } } >
        CoinSpark Admin Dashboard <
        /h1> <
        div style = {
            { display: 'flex', alignItems: 'center', gap: '1rem' } } >
        <
        span > Welcome, { user ? .email } < /span> <
        button onClick = { handleLogout }
        style = {
            {
                backgroundColor: '#ef4444',
                color: 'white',
                padding: '0.5rem 1rem',
                border: 'none',
                borderRadius: '4px',
                cursor: 'pointer'
            }
        } >
        Logout <
        /button> <
        /div> <
        /div>

        <
        div style = {
            {
                backgroundColor: 'white',
                padding: '1.5rem',
                borderRadius: '8px',
                boxShadow: '0 1px 3px rgba(0,0,0,0.1)'
            }
        } >
        <
        h2 style = {
            { marginBottom: '1rem' } } > Quick Stats < /h2> <
        div style = {
            { display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '1rem' } } >
        <
        div style = {
            { padding: '1rem', backgroundColor: '#f3f4f6', borderRadius: '4px' } } >
        <
        h3 style = {
            { fontSize: '0.875rem', color: '#6b7280' } } > Total Articles < /h3> <
        p style = {
            { fontSize: '1.5rem', fontWeight: 'bold' } } > 0 < /p> <
        /div> <
        div style = {
            { padding: '1rem', backgroundColor: '#f3f4f6', borderRadius: '4px' } } >
        <
        h3 style = {
            { fontSize: '0.875rem', color: '#6b7280' } } > Published < /h3> <
        p style = {
            { fontSize: '1.5rem', fontWeight: 'bold' } } > 0 < /p> <
        /div> <
        div style = {
            { padding: '1rem', backgroundColor: '#f3f4f6', borderRadius: '4px' } } >
        <
        h3 style = {
            { fontSize: '0.875rem', color: '#6b7280' } } > Drafts < /h3> <
        p style = {
            { fontSize: '1.5rem', fontWeight: 'bold' } } > 0 < /p> <
        /div> <
        /div> <
        /div>

        <
        div style = {
            { marginTop: '2rem' } } >
        <
        button style = {
            {
                backgroundColor: '#3b82f6',
                color: 'white',
                padding: '0.75rem 1.5rem',
                border: 'none',
                borderRadius: '4px',
                cursor: 'pointer',
                fontSize: '1rem'
            }
        } >
        Manage Articles <
        /button> <
        /div> <
        /div>
    )
}
