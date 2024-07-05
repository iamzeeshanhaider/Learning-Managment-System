@props([
    'type' => 'file',
    'folder' => '',
    'route' => null,
])
<div class="col-lg-4 col-md-6 mb-3 iro_card h-auto">
    @switch($type)
        @case('action')
            <div class="m-3 card border border-primary rounded d-flex align-items-center justify-content-center"
                style="min-height: 160px">
                <a onclick="handleGeneralModal(this)" class="text-center text-primary" data-link="{{ $route }}"
                    title="Create Folder">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="60px" height="60px">
                        <path style="fill:#007bff;"
                            d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 24 13 L 24 24 L 13 24 L 13 26 L 24 26 L 24 37 L 26 37 L 26 26 L 37 26 L 37 24 L 26 24 L 26 13 L 24 13 z" />
                    </svg>
                    New Folder
                </a>
            </div>
        @break

        @default
            <div class="card border-0 shadow p-3 rounded">
                @if (!auth()->user()->isStudent())
                    <div class="d-flex justify-content-between align-content-center">
                        <div class="btn-group dropright">
                            <a class="dropdown-toggle text-center mx-auto" href="#" role="button" id="folderDropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="folderDropdown">
                                <li>
                                    <a class="dropdown-item cursor-pointer" onclick="handleGeneralModal(this)"
                                        data-link="{{ route('lesson.folder.edit', ['folder' => $folder->slug, 'lesson' => $folder->lesson->slug]) }}"
                                        title="Edit Folder">
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <form
                                        action="{{ route('lesson.folder.destroy', ['folder' => $folder->slug, 'lesson' => $folder->lesson->slug]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to archive this folder and all associated resources?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item"
                                            style="border: none; background-color: transparent; cursor: pointer;">
                                            Archive
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <a class="dropdown-item cursor-pointer" href="{{ route('lesson.folder.duplicate', ['folder' => $folder->slug, 'lesson' => $folder->lesson->slug]) }}"
                                        title="Edit Folder">
                                        Duplicate
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <span class="badge badge-{{ $folder->is_published ? 'primary' : 'danger' }}">
                                {{ $folder->is_published ? 'Published' : 'Un-Published' }}
                            </span>
                        </div>
                    </div>
                @endif
                <a href="{{ $route ?? '#' }}" class="text-center mx-auto">
                    <div class="d-flex align-content-center justify-content-center">
                        <svg height="100px" width="100px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                            fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path id="SVGCleanerId_0" style="fill:#FFC36E;"
                                    d="M183.295,123.586H55.05c-6.687,0-12.801-3.778-15.791-9.76l-12.776-25.55 l12.776-25.55c2.99-5.982,9.103-9.76,15.791-9.76h128.246c6.687,0,12.801,3.778,15.791,9.76l12.775,25.55l-12.776,25.55 C196.096,119.808,189.983,123.586,183.295,123.586z">
                                </path>
                                <g>
                                    <path id="SVGCleanerId_0_1_" style="fill:#FFC36E;"
                                        d="M183.295,123.586H55.05c-6.687,0-12.801-3.778-15.791-9.76l-12.776-25.55 l12.776-25.55c2.99-5.982,9.103-9.76,15.791-9.76h128.246c6.687,0,12.801,3.778,15.791,9.76l12.775,25.55l-12.776,25.55 C196.096,119.808,189.983,123.586,183.295,123.586z">
                                    </path>
                                </g>
                                <path style="fill:#EFF2FA;"
                                    d="M485.517,70.621H26.483c-4.875,0-8.828,3.953-8.828,8.828v44.138h476.69V79.448 C494.345,74.573,490.392,70.621,485.517,70.621z">
                                </path>
                                <rect x="17.655" y="105.931" style="fill:#E1E6F2;" width="476.69" height="17.655"></rect>
                                <path style="fill:#FFD782;"
                                    d="M494.345,88.276H217.318c-3.343,0-6.4,1.889-7.895,4.879l-10.336,20.671 c-2.99,5.982-9.105,9.76-15.791,9.76H55.05c-6.687,0-12.801-3.778-15.791-9.76L28.922,93.155c-1.495-2.99-4.552-4.879-7.895-4.879 h-3.372C7.904,88.276,0,96.18,0,105.931v335.448c0,9.751,7.904,17.655,17.655,17.655h476.69c9.751,0,17.655-7.904,17.655-17.655 V105.931C512,96.18,504.096,88.276,494.345,88.276z">
                                </path>
                                <path style="fill:#FFC36E;"
                                    d="M485.517,441.379H26.483c-4.875,0-8.828-3.953-8.828-8.828l0,0c0-4.875,3.953-8.828,8.828-8.828 h459.034c4.875,0,8.828,3.953,8.828,8.828l0,0C494.345,437.427,490.392,441.379,485.517,441.379z">
                                </path>
                                <path style="fill:#EFF2FA;"
                                    d="M326.621,220.69h132.414c4.875,0,8.828-3.953,8.828-8.828v-70.621c0-4.875-3.953-8.828-8.828-8.828 H326.621c-4.875,0-8.828,3.953-8.828,8.828v70.621C317.793,216.737,321.746,220.69,326.621,220.69z">
                                </path>
                                <path style="fill:#C7CFE2;"
                                    d="M441.379,167.724h-97.103c-4.875,0-8.828-3.953-8.828-8.828l0,0c0-4.875,3.953-8.828,8.828-8.828 h97.103c4.875,0,8.828,3.953,8.828,8.828l0,0C450.207,163.772,446.254,167.724,441.379,167.724z">
                                </path>
                                <path style="fill:#D7DEED;"
                                    d="M441.379,203.034h-97.103c-4.875,0-8.828-3.953-8.828-8.828l0,0c0-4.875,3.953-8.828,8.828-8.828 h97.103c4.875,0,8.828,3.953,8.828,8.828l0,0C450.207,199.082,446.254,203.034,441.379,203.034z">
                                </path>
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h5>{{ $folder->name }}</h5>
                    </div>
                </a>
            </div>
    @endswitch
</div>
