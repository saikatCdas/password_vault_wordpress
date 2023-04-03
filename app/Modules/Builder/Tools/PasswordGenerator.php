<?php

namespace FluentPlugin\App\Modules\Builder\Tools;


class PasswordGenerator
{
    public function render()
    {
        ob_start();
        ?>
            <div class="w-full">
                <div>
                    <h1 class="text-3xl text-gray-700">Generator</h1>
                    <hr class="mt-4">
                </div>
                <div class="flex items-center  w-full h-16 border border-gray-300 mt-4 ">
                    <p id="show-generator-password" class="text-center text-gray-700 text-[18px] w-full"></p>
                    <button
                        type="button" class="relative password-copy-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-400 cursor-pointer top-0 copy-generator-password">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                        </svg>
                        <p id="password-copy-text" class="absolute font-semibold -top-3 right-6 text-blue-500 rounded-md">copy</p>
                    </button>
                </div>
                <div class="mt-4 text-gray-600">
                    <h2 class="font-semibold text-gray-600">What would you like to generate??</h2>
                    <div class="mt-1 flex items-center">
                        <input type="radio" id="password" value="password" class="form-radio mr-2 rounded-full" name="password-generator" checked>
                        <label class="'ml-2 mr-3 text-[15px]'" for="password">Password</label>
                        <input type="radio" id="passphrase" value="passphrase" class="form-radio rounded-full ml-4 mr-2" name="password-generator">
                        <label class="'ml-2 text-[15px]'" for="passphrase">Passphrase</label>
                    </div>
                </div>
                <div id="password-generator-type">
                    <div id='generator-type-password' class="mt-5">
                        <div class="lg:flex items-center lg:space-x-5 w-full">
                            <div class="mb-4 md:min-w-[40%] lg:min-w-[25%]">
                                <label class="block text-gray-600 font-medium mb-2" for="length">
                                    Length
                                </label>
                                <input
                                class="bg-gray-50 border border-gray-300 py-1 px-5 w-full rounded-md text-gray-600 "
                                type="number"
                                id="length"
                                value="8"
                                max="80"
                                min="6"
                                required
                                />
                            </div>
                            <div class="mb-4 md:min-w-[40%] lg:min-w-[25%]">
                                <label class="block text-gray-600 font-medium mb-2" for="number">
                                    Minimum numbers
                                </label>
                                <input
                                class="bg-gray-50 border border-gray-300 py-1 px-5 w-full rounded-md text-gray-600"
                                type="number"
                                id="min-numeric-chars"
                                max="80"
                                min="0"
                                value="2"
                                />
                            </div>
                            <div class="mb-4 md:min-w-[40%] lg:min-w-[25%]">
                                <label class="block text-gray-600 font-medium mb-2" for="spCharacter">
                                    Minimum special character
                                </label>
                                <input
                                class="bg-gray-50 border border-gray-300 py-1 px-5 w-full rounded-md text-gray-600"
                                type="number"
                                id="min-special-chars"
                                max="80"
                                min="0"
                                value="2"
                                />
                            </div>
                        </div>
                        <div class="mb-4" id="checkbox-container">
                            <h2 class="font-semibold text-[16px] text-gray-600 mb-2">
                                Options
                            </h2>
                            <div class="mb-1 flex items-center ">
                                <input
                                class="border border-gray-300 rounded-sm  mr-3"
                                type="checkbox"
                                id="capital-letters"
                                name="capital-letters"
                                checked
                                />
                                <label class="block text-gray-600 font-medium text-sm" for="capital-letters">
                                    A-Z
                                </label>
                            </div>
                            <div class="mb-1 flex items-center ">
                                <input
                                class="border border-gray-300 rounded-sm  mr-3"
                                type="checkbox"
                                id="small-letters"
                                name="small-letters"
                                checked
                                />
                                <label class="block text-gray-600 font-medium text-sm" for="small-letters">
                                    a-z
                                </label>
                            </div>
                            <div class="mb-1 flex items-center ">
                                <input
                                class="border border-gray-300 rounded-sm  mr-3"
                                type="checkbox"
                                id="numbers"
                                name="numbers"
                                checked
                                />
                                <label class="block text-gray-600 font-medium text-sm" for="numbers">
                                    0-9
                                </label>
                            </div>
                            <div class="mb-1 flex items-center ">
                                <input
                                class="border border-gray-300 rounded-sm  mr-3 "
                                type="checkbox"
                                id="special-character"
                                name="special-character"
                                checked
                                />
                                <label class="block text-gray-600 font-medium text-sm" for="special-character">
                                    !@#$%^&*()
                                </label>
                            </div>
                        </div>

                    </div>
                    <div id='generator-type-passphrase' class="mt-5">
                        <div class="md:flex md:space-x-5 items-center w-full">
                            <div class="mb-4 md:w-[35%] lg:w-[25%]">
                                <label class="block text-gray-600 font-medium mb-2" for="num-words">
                                    Number of words
                                </label>
                                <input
                                class="bg-gray-50 border border-gray-300 py-1 px-5 w-full rounded-md text-gray-600"
                                type="number"
                                id="num-words"
                                max="10"
                                min="2"
                                value="2"
                                />
                            </div>
                            <div class="mb-4 md:w-[35%] lg:w-[25%]">
                                <label class="block text-gray-600 font-medium mb-2" for="word-separator">
                                    Word Separator
                                </label>
                                <input
                                class="bg-gray-50 border border-gray-300 py-1 px-5 w-full rounded-md text-gray-600"
                                type="text"
                                id="word-separator"
                                value="-"
                                />
                            </div>
                        </div>
                        <div class="mb-4">
                            <h2 class="font-semibold text-[16px] text-gray-600 mb-2">
                                Options
                            </h2>
                            <div class="mb-1 flex items-center ">
                                <input
                                class="border border-gray-300 rounded-sm  mr-3"
                                type="checkbox"
                                id="capitalize" 
                                name="capitalize"
                                checked
                                />
                                <label class="block text-gray-600 font-medium text-sm" for="capitalize">
                                    Capitalize
                                </label>
                            </div>
                            <div class="mb-1 flex items-center ">
                                <input
                                class="border border-gray-300 rounded-sm  mr-3 "
                                type="checkbox" 
                                id="include-number" 
                                name="include-number" 
                                checked
                                />
                                <label class="block text-gray-600 font-medium text-sm" for="include-number">
                                    Include Number
                                </label>
                            </div>
                        </div>

                    </div>
                        
                        <!-- regenerator and copy Buttons -->
                    <div class="flex max-sm:flex-col max-sm:space-y-1 sm:space-x-2">
                        <button type=" button" id="password-regenerator-button" class="py-1 px-3 text-lg rounded-md border bg-emerald-500 hover:bg-emerald-600 text-white">Regenerate Password</button>
                        <button 
                            type="button"
                            class="text-gray-600 text-lg border border-gray-400 px-3 py-1 rounded-md copy-generator-password"
                        >
                            Copy password
                        </button>
                </div>
                
                </div>
            </div>
        <?php

        return ob_get_clean();
    }
}