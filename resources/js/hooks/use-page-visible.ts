import { useEffect, useState } from 'react';

export function usePageVisible() {
    const [visible, setVisible] = useState(() => typeof document === 'undefined' || document.visibilityState === 'visible');

    useEffect(() => {
        const update = () => setVisible(document.visibilityState === 'visible');

        update();
        document.addEventListener('visibilitychange', update);
        return () => document.removeEventListener('visibilitychange', update);
    }, []);

    return visible;
}
