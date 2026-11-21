import { useEffect, useRef } from 'react';

import { useMediaQuery } from '@/hooks/use-media-query';

type Kind = 'snow' | 'embers';

interface Particle {
    x: number;
    y: number;
    r: number;
    speed: number;
    drift: number;
    phase: number;
    alpha: number;
}

function spawn(kind: Kind, width: number, height: number, anywhere: boolean): Particle {
    return {
        x: Math.random() * width,
        y: anywhere ? Math.random() * height : kind === 'snow' ? -10 : height + 10,
        r: kind === 'snow' ? 0.8 + Math.random() * 2.2 : 0.9 + Math.random() * 1.8,
        speed: kind === 'snow' ? 0.25 + Math.random() * 0.55 : 0.3 + Math.random() * 0.6,
        drift: 0.3 + Math.random() * 0.7,
        phase: Math.random() * Math.PI * 2,
        alpha: kind === 'snow' ? 0.35 + Math.random() * 0.5 : 0.4 + Math.random() * 0.5,
    };
}

export function SeasonParticles({ kind }: { kind: Kind }) {
    const canvasRef = useRef<HTMLCanvasElement>(null);
    const calm = useMediaQuery('(prefers-reduced-motion: reduce)');

    useEffect(() => {
        const canvas = canvasRef.current;
        const context = canvas?.getContext('2d');
        if (!canvas || !context || calm) {
            return;
        }

        let width = 0;
        let height = 0;
        let particles: Particle[] = [];
        let frame = 0;

        const resize = () => {
            const ratio = window.devicePixelRatio || 1;
            width = canvas.clientWidth;
            height = canvas.clientHeight;
            canvas.width = width * ratio;
            canvas.height = height * ratio;
            context.setTransform(ratio, 0, 0, ratio, 0, 0);
            const count = Math.round(Math.min(110, (width * height) / 14000) * (kind === 'snow' ? 1 : 0.8));
            particles = Array.from({ length: count }, () => spawn(kind, width, height, true));
        };

        const draw = (time: number) => {
            context.clearRect(0, 0, width, height);
            for (const particle of particles) {
                const sway = Math.sin(time / 1800 + particle.phase) * particle.drift;
                particle.x += sway * 0.4;
                particle.y += kind === 'snow' ? particle.speed : -particle.speed;

                if (particle.y > height + 10 || particle.y < -10 || particle.x < -10 || particle.x > width + 10) {
                    Object.assign(particle, spawn(kind, width, height, false));
                }

                context.beginPath();
                context.arc(particle.x, particle.y, particle.r, 0, Math.PI * 2);
                if (kind === 'snow') {
                    context.fillStyle = `rgba(255, 255, 255, ${particle.alpha})`;
                } else {
                    const flicker = 0.6 + 0.4 * Math.sin(time / 300 + particle.phase);
                    context.fillStyle = `rgba(255, ${110 + Math.round(60 * flicker)}, 40, ${particle.alpha * flicker})`;
                }
                context.fill();
            }
            frame = requestAnimationFrame(draw);
        };

        const onVisibility = () => {
            cancelAnimationFrame(frame);
            if (!document.hidden) {
                frame = requestAnimationFrame(draw);
            }
        };

        resize();
        frame = requestAnimationFrame(draw);
        const observer = new ResizeObserver(resize);
        observer.observe(canvas);
        document.addEventListener('visibilitychange', onVisibility);

        return () => {
            cancelAnimationFrame(frame);
            observer.disconnect();
            document.removeEventListener('visibilitychange', onVisibility);
        };
    }, [kind, calm]);

    if (calm) {
        return null;
    }

    return <canvas ref={canvasRef} className="pointer-events-none absolute inset-0 z-[5] size-full" aria-hidden="true" />;
}
