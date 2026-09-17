export function Footer() {
    return (
        <footer className="border-t border-border bg-[#1a2128] bg-[url('/images/footer-bg.jpg')] bg-top bg-no-repeat">
            <div className="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-12 sm:flex-row sm:items-center">
                <img src="/images/official-logo.png" alt="Angels of Death" className="h-16 w-auto shrink-0" />
                <div>
                    <h2 className="text-lg font-semibold">About The Angels of Death</h2>
                    <p className="mt-2 max-w-2xl text-sm text-muted-foreground">
                        The Angels of Death is a community of players founded in 1999 based on a core set of conduct that aims to promote decency and
                        provide a comfortable environment to play with thousands of other likeminded members.
                    </p>
                </div>
            </div>

            <div className="border-t border-border px-4 py-6 text-center text-xs text-muted-foreground">
                <span>Copyright &copy; 1999 - {new Date().getFullYear()} Angels of Death. All rights reserved.</span>
                <span className="mx-2">-</span>
                <a href="/privacy-policy" className="hover:text-foreground">
                    Privacy Policy
                </a>
                <span className="mx-2">-</span>
                <a href="/terms-of-use" className="hover:text-foreground">
                    Terms of Use
                </a>
            </div>
        </footer>
    );
}
